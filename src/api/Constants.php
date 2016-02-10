<?php

namespace Snapchat\API;

class Constants {

    /*
	 * The API Base URL.
	 */
    const BASE_URL = "https://app.snapchat.com";

    /*
	 * The API Secret. Used to create Request Tokens.
	 */
    const SECRET = "iEk21fuwZApXlz93750dmW22pw389dPwOk";

    /*
     * The Static Token. Used when no AuthToken is available.
     */
    const STATIC_TOKEN = "m198sOkJEn37DjqZ32lpRu76xmw288xSQ9";

    /*
     * The Hash Pattern. Use to create Request Tokens.
     */
    const HASH_PATTERN = "0001110111101110001111010101111011010001001110011000110001000110";

    /*
     * Hardcoded Device Screen Sizes
     */
    const SCREEN_WIDTH_IN = "5.82";
    const SCREEN_HEIGHT_IN = "7.75";
    const SCREEN_WIDTH_PX = "320";
    const SCREEN_HEIGHT_PX = "480";

}