<?php
 translate_to_arabic($text) {
    // Prepare the API request URL.
    $api_key = "aizaSyBFbAuJ26218uMKPPy0DqnygyF32GbcKJE";
    $api_url = "https://translation.googleapis.com/language/translate/v2?key=$api_key";

    // Prepare the API request data.
    $request_data = array(
        'q' => $text,
        'source' => 'en', // Assuming the original text is in English.
        'target' => 'ar', // Arabic language code.
    );

    // Make the API request.
    $response = wp_remote_post($api_url, array(
        'body' => $request_data,
    ));

    if (!is_wp_error($response) && $response['response']['code'] === 200) {
        $translated_data = json_decode($response['body'], true);
        if (isset($translated_data['data']['translations'][0]['translatedText'])) {
            return $translated_data['data']['translations'][0]['translatedText'];
        }
    }

    // Return the original text on failure.
    return $text;
}

function translate_text_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'text' => '',
        ),
        $atts,
        'translate_text'
    );

    // Get the text and API key from shortcode attributes.
    $text = $atts['text'];

    // Check if text is provided.
    if (empty($text)) {
        return 'No text provided';
    }

    // Translate the text to Arabic.
    $translated_text = translate_to_arabic($text);

    if (!is_wp_error($translated_text)) {
        // Return the translated text.
        return $translated_text;
    } else {
        // Handle translation failure.
        $error_message = $translated_text->get_error_message();
        // You can display the error message or perform any other actions.
        return "Translation Error: $error_message";
    }
}
add_shortcode('translate_text', 'translate_text_shortcode');

    $post_title = get_the_title(1);
	echo translate_to_arabic("Mamoon");


?>
