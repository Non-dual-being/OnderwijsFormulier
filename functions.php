add_action('admin_post_nopriv_submit_geofort_form', 'handle_geofort_form_submission');
add_action('admin_post_submit_geofort_form', 'handle_geofort_form_submission');

function handle_geofort_form_submission() {
    // Ontvang de gegevens
    $emailadres = sanitize_email($_POST['emailadres']);
    $contactpersoonvoornaam = sanitize_text_field($_POST['contactpersoonvoornaam']);
    $contactpersoonachternaam = sanitize_text_field($_POST['contactpersoonachternaam']);
    $telefoonnummer = sanitize_text_field($_POST['telefoonnummer']);
    $overzichtAanvrager = sanitize_textarea_field($_POST['overzichtAanvrager']);
    $overzichtGeoFortMedewerker = sanitize_textarea_field($_POST['overzichtGeoFortMedewerker']);

    // Mailchimp API-integratie
    $api_key = 'YOUR_MAILCHIMP_API_KEY';
    $list_id = 'YOUR_MAILCHIMP_LIST_ID';
    $data_center = substr($api_key, strpos($api_key, '-') + 1);
    $url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/';

    $data = array(
        'email_address' => $emailadres,
        'status' => 'subscribed',
        'merge_fields' => array(
            'FNAME' => $contactpersoonvoornaam,
            'LNAME' => $contactpersoonachternaam,
            'PHONE' => $telefoonnummer,
            // Voeg andere velden toe indien nodig
        )
    );

    $json_data = json_encode($data);

    $args = array(
        'body' => $json_data,
        'headers' => array(
            'Authorization' => 'apikey ' . $api_key,
            'Content-Type' => 'application/json'
        )
    );

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo "Something went wrong: $error_message";
    } else {
        // Verstuur een bevestigingsmail naar de aanvrager
        wp_mail($emailadres, 'Bevestiging onderwijsaanvraag GeoFort', $overzichtAanvrager);

        // Verstuur een melding naar de GeoFort-docent
        wp_mail('onderwijs@geofort.nl', 'Nieuwe onderwijsaanvraag', $overzichtGeoFortMedewerker);

        // Redirect na succesvolle verzending
        wp_redirect(home_url('/dankjewel'));
        exit;
    }
}
