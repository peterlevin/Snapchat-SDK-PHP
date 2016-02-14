<?php

use Snapchat\Util\FileUtil;

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    register_account: {

        echo "Email: ";
        $email = trim(fgets(STDIN));

        echo "Password: ";
        $password = trim(fgets(STDIN));

        echo "Birthday (YYYY-MM-DD): ";
        $birthday = trim(fgets(STDIN));

        echo "Registering Account...\n";

        try {
            $snapchat->register($email, $password, $birthday, "America/New_York");
        } catch(Exception $e){
            echo $e->getMessage() . "\n";
            goto register_account;
        }

        echo "Account Registered, Link a Username!\n";
        goto link_username;

    }

    link_username: {

        echo "Username: ";
        $username = trim(fgets(STDIN));

        try {
            $snapchat->registerUsername($username);
        } catch(Exception $e){
            echo $e->getMessage() . "\n";
            goto link_username;
        }

        echo "Username Linked, Account Verification is now Required!\n";
        goto choose_verify_method;

    }

    choose_verify_method: {

        echo "Please choose a Verification Method:\n";
        echo "1) Captcha\n";
        echo "2) Phone Call\n";
        echo "3) Phone SMS\n";

        echo "Method: ";
        $verificationMethod = trim(fgets(STDIN));

        switch($verificationMethod){

            case "1": {

                echo "Downloading Captcha...\n";

                try {

                    $captcha = $snapchat->getCaptcha("download/captcha");

                    echo "The Captcha solution is a string of 1's and 0's.\n";
                    echo sprintf("View the Images in the folder:  %s\n", $captcha->getFolder());
                    echo "If the Image has a Ghost, enter a 1 else enter a 0.\n";
                    echo "Folder will be deleted afterwards.\n";

                    echo "Solution: ";
                    $solution = trim(fgets(STDIN));

                    $snapchat->solveCaptcha($captcha->getId(), $solution);

                    FileUtil::deleteDirectory($captcha->getFolder());

                    goto done;

                } catch(Exception $e){
                    echo $e->getMessage() . "\n";
                    goto choose_verify_method;
                }

            }

            case "2": {

                echo "Phone Number: ";
                $phoneNumber = trim(fgets(STDIN));

                echo "Country Code (eg: US): ";
                $countryCode = trim(fgets(STDIN));

                try {

                    $updatePhoneResponse = $snapchat->updatePhoneNumberWithCall($countryCode, $phoneNumber);
                    echo $updatePhoneResponse->getMessage() . "\n";

                    goto verify_phone;

                } catch(Exception $e){
                    echo $e->getMessage() . "\n";
                    goto choose_verify_method;
                }

                break;

            }

            case "3": {

                echo "Phone Number: ";
                $phoneNumber = trim(fgets(STDIN));

                echo "Country Code (eg: US): ";
                $countryCode = trim(fgets(STDIN));

                try {

                    $updatePhoneResponse = $snapchat->updatePhoneNumber($countryCode, $phoneNumber);
                    echo $updatePhoneResponse->getMessage() . "\n";

                    goto verify_phone;

                } catch(Exception $e){
                    echo $e->getMessage() . "\n";
                    goto choose_verify_method;
                }

                break;

            }

            default: {

                echo "Invalid Selection\n";
                goto choose_verify_method;

            }

        }

    }

    verify_phone: {

        echo "Verification Code: ";
        $code = trim(fgets(STDIN));

        try {

            $phoneVerifyResponse = $snapchat->verifyPhoneNumber($code);
            echo $phoneVerifyResponse->getMessage() . "\n";

            goto done;

        } catch(Exception $e){
            echo $e->getMessage() . "\n";
            goto choose_verify_method;
        }

    }

    done: {
        echo "Account Verified, all done!\n";
    }


} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}