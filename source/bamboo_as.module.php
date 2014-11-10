<?php
define('DEBUG', TRUE);
//define('BSP_ROOT', 'http://bsp-dev.projectbamboo.org:8181/bsp/');
define('BSP_ROOT', 'https://bsp-dev.projectbamboo.org/xyz/bsp/');
//TODO: I need the default bpid to create a bpid apparently. Confirm with Fernando.
define('HEADERS', 'X-Bamboo-ROLES: unspecified@wisc.edu|member@folgerlibrary.org,X-Bamboo-APPID: urn:uuid:b3c7eefee03a4e03a3dca6ff7b8e7b85,X-Bamboo-BPID: urn:uuid:a52ec447-78d5-4a4e-bf1e-32ba92bf3dbe');
define('XMLDECLARATION', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n");
define('CONTENT_TYPE', 'text/xml');

require_once("bamboo_as_rest.inc");



/**
 * Implements hook_menu().
 */
function bamboo_as_menu() {
  $items = array();
  $items['user/bamboo/check_user'] = array(
    'page callback' => 'bamboo_as_check_user',
    'access callback' => 'bamboo_as_custom_access',
    'access arguments' => array('authenticated user'),
  );
  $items['user/bamboo/manage_profile'] = array(
    'title' => 'Bamboo Profile Management',
    'description' => 'Manage your Bamboo Profile',
    'access callback' => 'bamboo_as_custom_access',
    'access arguments' => array('authenticated user'),
  /*
   'page arguments' => array('bamboo_as_manage_profile_form'),
   'page callback' => 'drupal_get_form',
   */
    'page callback' => 'bamboo_as_manage_profile_page',
  );
  $items['user/bamboo/manage_identity'] = array(
    'title' => 'Bamboo Identity Management',
    'description' => 'Manage your Bamboo Identity',
    'page callback' => 'bamboo_as_manage_identity',
    'access callback' => 'bamboo_as_custom_access',
    'access arguments' => array('authenticated user'),

  );

  return $items;
}

/**
 * Determine whether the current user has the role specified.
 *
 * @param $role_name
 *   The role required for access
 * @return bool
 *   True if the acting user has the role specified.
 */
function bamboo_as_custom_access($role_name){
  $access_granted = in_array($role_name, $GLOBALS['user']->roles);
  return $access_granted;
}


/**
 * Return headers to be used in REST request
 */
function bamboo_as_get_headers() {
  $headers = explode(',', HEADERS);
  if (isset($_SESSION['bpid'])) {
    //remove the default X-Bamboo-BPID
    array_pop($headers);
    $headers = array_merge($headers, array('X-Bamboo-BPID: ' . $_SESSION['bpid']));
  }
  return $headers;
}

/**
 * Implements hook_user_login(). for local testing using shib_fake.module
 * Determine if they have a Bamboo Person Id (BPid)
 */
function bamboo_as_user_login(&$edit, $account) {
  bamboo_as_check_user();
}

/**
 * Check if the auth'd user has a bpid and send them to the appropriate page
 * admin/config/people/shib_auth/advanced should be configured to redirect here
 */
function bamboo_as_check_user() {
  global $_SERVER;
  //TODO: This is a hack until the IdPs can all be made consistent
  if ($_SERVER['Shib-Identity-Provider'] == 'https://shib-test.berkeley.edu/idp/shibboleth') {
    /*
     * There is no persistent-id returned for UCB so fake one
     *
     */
    $userid = hash('sha256', $_SERVER['Shib-Identity-Provider'] . '!' . 'https://accounts-dev.projectbamboo.org/shibboleth-sp!' . hash('sha256', $_SERVER['eppn']));
  }
  else {
    if (!isset($_SERVER['persistent-id']) || !isset($_SERVER['Shib-Identity-Provider'])) {
      drupal_set_message('Required variables are not present. Please ensure that both shib_auth and all the identity providers are configured corretly.', 'error');
      return;
    }
    $userid = hash('sha256', $_SERVER['persistent-id']);
  }

  //TODO: verify that this is the correct data for the digest
  if (isset($_SERVER['sha256-fake'])) {
    $userid = $_SERVER['sha256-fake'];
  }

  (!empty($userid)) ? $_SESSION['userid'] = $userid : drupal_set_message('userid is empty', 'error');
  if (!empty($_SERVER['Shib-Identity-Provider'])) {
    $_SESSION['shib_idp'] = $_SERVER['Shib-Identity-Provider'];
  }
  else {
    drupal_set_message('IdP config error Shib-Identity-Provider not present', 'error');
  }

  // Read bpid
  $endpoint = "persons/sourcedid/?idpid=" . $_SERVER['Shib-Identity-Provider'] . "&userid=$userid";
  $url = BSP_ROOT . $endpoint;
  $headers = bamboo_as_get_headers();
  $personRest = new REST_client($url);
  $result = $personRest->doRequest($url, 'GET', null, null, null, $headers);

  //TODO: if CURLOPT_FOLLOWLOCATION will we ever see 301 or 302?
  if (($result->code !=200 && $result->code != 302 && $result->code != 301) || $result->location == '') {
    $bpid = NULL;
  } else {
    $bpidresult = $result->location;
    // The BPID is the last element in the location URL
    $pieces = explode('/', $bpidresult);
    //TODO drupal SESSION best practices
    $_SESSION['bpid'] = array_pop($pieces);
  }

  /*
   * TODO: Verify: The redirection won't work if user logged in with the login block form, but
   * they should never be using the login block form if they are authenticating via
   * a 3rd party idp.  If they did use the login block form, the required vars won't exist in
   * $_SERVER and they'll see the error.
   *
   * $edit['redirect'] works if you come from user/login (for testing with shib_fake).
   */
  if (isset($_SESSION['bpid'])) {
    //TODO: redirect doesn't work from the login block.  use drupal_goto?
    drupal_goto('user/bamboo/manage_profile');
  }
  else {
    drupal_goto('user/bamboo/manage_identity');
  }
}

/**
 * Create a BpId for a user
 */
function bamboo_as_create_identity() {
  //global $headers; //scope issue...use constant

  $xml = XMLDECLARATION;
  $xml .=<<<XML
  <person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <person:sourcedId>
    <person:sourcedIdName></person:sourcedIdName>
    <person:sourcedIdKey>
      <person:idPId></person:idPId>
      <person:userId></person:userId>
    </person:sourcedIdKey>
  </person:sourcedId>
</person:bambooPerson>
XML;

  $sx_sourcedId = simplexml_load_string($xml);
  bamboo_as_simplexml_error($sx_sourcedId);
  $ns = $sx_sourcedId->getDocNamespaces(TRUE);

  $sx_sourcedId->children($ns['person'])->sourcedId[0]->sourcedIdKey->idPId = $_SESSION['shib_idp'];
  $sx_sourcedId->children($ns['person'])->sourcedId[0]->sourcedIdKey->userId = $_SESSION['userid'];
  $xml_prepared = trim(preg_replace('/<\?xml[^>]+>/', '', $sx_sourcedId->asXML()));

  $url = BSP_ROOT . "persons";
  $headers = bamboo_as_get_headers();
  $personRest = new REST_client($url);
  $result = $personRest->doRequest($url, 'POST', $xml_prepared, 'text/xml', null, $headers);

  //TODO: 201 for a post.
  if ($result->code !=201 && $result->code != 302 && $result->code != 301) {
    $bpid = NULL;
    drupal_set_message('Create bpid failed with error code ' . $result->code, 'error');
    if (DEBUG) {
      drupal_set_message($result->body, 'error');
      drupal_set_message($result->body, 'error');
      drupal_set_message("url = $url", 'error');
      drupal_set_message("<pre>" . htmlentities($xml_prepared) . "</pre>", 'error');
    }
  }
  else {
    $bpidresult = $result->location;
    // The BPID is the last element in the location URL
    $pieces = explode('/', $bpidresult);
    $bpid = array_pop($pieces);
    //TODO drupal SESSION best practices
    $_SESSION['bpid'] = $bpid;
    if (DEBUG) {
      drupal_set_message("BPId: $bpid");
      drupal_set_message("<pre>" . htmlentities($xml_prepared) . "</pre>");
    }
  }
}

/**
 *
 * Manage id page
 */
function bamboo_as_manage_identity() {
  $out = '<ul>';
  $out .= '<li>'. l('Create new Bamboo Person Identity', 'user/bamboo/manage_profile') . '</li>';
  $out .= '<li>Associate SourcedID with existing Bamboo Person Identity (not implemented)</li>';
  $out .= '</ul>';
  return $out;
}

/**
 * manage profile
 */
function bamboo_as_manage_profile_page() {
  drupal_set_title('Manage your Bamboo Profile');
  if (isset($_SESSION['bpid'])) {
    $url = BSP_ROOT . "persons/" . $_SESSION['bpid'] . "/profiles";
    /*
     //list profiles for bpid

     $headers = bamboo_as_get_headers();
     $personRest = new REST_client($url);
     $result = $personRest->doRequest($url, 'GET', null, null, null, $headers);
     if ($result->code != 200) {
     drupal_set_message('Could not find profiles for bpid: ' . $result->code, 'warning');
     return;
     }
     $sx_profiles = simplexml_load_string($result->body);
     $ns = $sx_profiles->getDocNamespaces();
     bamboo_as_simplexml_error($sx_profiles);
     $person = $sx_profiles->children($ns['person']);
     $profile = $person->bambooProfile;
     //$profile = new SimpleXMLElement("<foo></foo>");
     $out[] = drupal_get_form('bamboo_as_manage_profile_form', $profile);

     $profiles = $sx_profiles->children($ns['person']);
     drupal_set_message(count($profiles) . " profile(s) found.", "status");
     $i = 1;
     $out = array();
     foreach ($profiles as $p) {
     $contacts = $p->children($ns['contacts']);
     $out[] = drupal_get_form('bamboo_as_manage_profile_form', null, $p->bambooProfile);
     drupal_set_message("Profile #$i contains " . count($contacts) . " contacts.");
     $i++;
     }
     */

    $out = 'You should alredy a have a profile.  Use Poster to check:<p>';
    $out .= "<pre>GET $url</pre>";
    return $out;

  }
  else {
    return drupal_get_form('bamboo_as_manage_profile_form');
  }


}

//<contacts:bambooContact>
function bamboo_as_contact_xml() {
  /*
   * removed
   <contacts:contactNote></contacts:contactNote>
   <contacts:emails>
   <contacts:email></contacts:email>
   </contacts:emails>
   <contacts:partNames>
   <contacts:partNameType>HONORIFIC_PREFIX</contacts:partNameType>
   <contacts:partNameContent>TESTC</contacts:partNameContent>
   <contacts:partNameLang></contacts:partNameLang>
   </contacts:partNames>
   <contacts:partNames>
   <contacts:partNameType>NAME_GIVEN</contacts:partNameType>
   <contacts:partNameContent></contacts:partNameContent>
   <contacts:partNameLang></contacts:partNameLang>
   </contacts:partNames>
   <contacts:partNames>
   <contacts:partNameType>NAME_FAMILY_PATERNAL</contacts:partNameType>
   <contacts:partNameContent></contacts:partNameContent>
   <contacts:partNameLang></contacts:partNameLang>
   </contacts:partNames>
   <contacts:partNames>
   <contacts:partNameType>NAME_FAMILY_MATERNAL</contacts:partNameType>
   <contacts:partNameContent></contacts:partNameContent>
   <contacts:partNameLang></contacts:partNameLang>
   </contacts:partNames>
   <contacts:partNames>
   <contacts:partNameType>HONORIFIC_SUFFIX</contacts:partNameType>
   <contacts:partNameContent></contacts:partNameContent>
   <contacts:partNameLang></contacts:partNameLang>
   </contacts:partNames>

   */

  $xml =<<<XML
<contacts:bambooContact xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact">
    <contacts:telephones>
        <contacts:telephoneType>VOICE</contacts:telephoneType>
        <contacts:locationType>HOME</contacts:locationType>
    </contacts:telephones>
    <contacts:telephones>
        <contacts:telephoneType>SMS</contacts:telephoneType>
        <contacts:telephoneNumber></contacts:telephoneNumber>
        <contacts:locationType>SABBATICAL</contacts:locationType>
    </contacts:telephones>
    <contacts:iMs>
        <contacts:instantMessagingType>SKYPE</contacts:instantMessagingType>
        <contacts:account></contacts:account>
        <contacts:locationType>WORK</contacts:locationType>
    </contacts:iMs>
    <contacts:addresses>
        <contacts:streetAddress1></contacts:streetAddress1>
        <contacts:streetAddress2></contacts:streetAddress2>
        <contacts:streetAddress3></contacts:streetAddress3>
        <contacts:locality></contacts:locality>
        <contacts:region></contacts:region>
        <contacts:postalCode></contacts:postalCode>
        <contacts:country></contacts:country>
        <contacts:locationType>WORK</contacts:locationType>
    </contacts:addresses>
</contacts:bambooContact>
XML;
  return $xml;
}

function bamboo_as_profile_xml() {
  $xml =<<<XML
<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">
<person:bambooProfile person:confidential="false" person:primary="true" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact" xmlns:person="http://projectbamboo.org/bsp/BambooPerson">
<person:profileId>testid</person:profileId>
<person:bambooPersonId>personid</person:bambooPersonId>
<person:profileInformation></person:profileInformation>
  <contacts:bambooContact>
    <contacts:contactId></contacts:contactId>
  </contacts:bambooContact>
  <person:interests person:confidential="false">
  </person:interests>
  <person:expertises person:confidential="false">
  </person:expertises>
  <person:externalAffiliations></person:externalAffiliations>
  <person:preferredLanguage></person:preferredLanguage>
  <person:languageUsedInScholarships></person:languageUsedInScholarships>
  <person:otherProfiles person:confidential="false">
    <person:profileName></person:profileName>
    <person:profileUrl></person:profileUrl>
  </person:otherProfiles>
  <person:authorizedPublisher>true</person:authorizedPublisher>
</person:bambooProfile>
</person:bambooPerson>
XML;
  return $xml;
}

function bamboo_as_create_contact() {

  $xml = bamboo_as_contact_xml();
  $url = BSP_ROOT . "contacts";
  $headers = bamboo_as_get_headers();
  $personRest = new REST_client($url);
  $result = $personRest->doRequest($url, 'POST', $xml, 'text/xml', null, $headers);

  //TODO: 201 for a post.
  if (($result->code !=201 && $result->code != 302 && $result->code != 301) || $result->location == '') {
    $contactid = NULL;
  } else {
    $contact_result = $result->location;
    $pieces = explode('/', $contact_result);
    $contact_id = array_pop($pieces);
    //TODO drupal SESSION best practices
  }
  return $contact_id;
}

function bamboo_as_contact_form() {
  // Do they have a profile?
  $url = BSP_ROOT . "persons/" . $_SESSION['bpid'] . "/profiles";
  $headers = bamboo_as_get_headers();
  $personRest = new REST_client($url);
  $result = $personRest->doRequest($url, 'GET', null, null, null, $headers);
  $xml = trim($result->body);
  $sx_profiles = simplexml_load_string($xml);
  bamboo_as_simplexml_error($sx_profiles);
  $ns = $sx_profiles->getDocNamespaces();

  // is there a primary profile?
  $primary_profile = null;
  foreach($sx_profiles->children($ns['person'])->bambooProfile as $profile) {
    $primary = $profile->attributes($ns['person'])->primary;
    if ($primary == 'true') { //'true' is a string
      $primary_profile = $profile;
    }
    if (isset($primary_profile)) break;
  }

  if ($primary_profile === null) {
    //No profile so create an empty contact which is required for a profile
    $contact_id = bamboo_as_create_contact();
    //Get the contact
    $url = BSP_ROOT . "contacts/" . $contact_id;
    $personRest = new REST_client($url);
    $result = $personRest->doRequest($url, 'GET', null, null, null, $headers);
    $xml = trim($result->body);
    $sx_contact = simplexml_load_string($xml);
    bamboo_as_simplexml_error($sx_contact);
    $ns = $sx_profiles->getDocNamespaces();

  }
  else {
    // get the whold contact, not just the contactid
    $sx_contact = $primary_profile->children($ns['person'])->bambooProfile[0]->children($ns['contacts'])->bambooContact[0];
  }

  $contact_form_fields = array(
  );

  $test = $sx_contact->asXML();

  $form['description'] = array(
    '#type' => 'item',
    '#title' => t('Contact Form'),
  );

}

/**
 * Map xml element to form fields
 */
function bamboo_as_xml_form_map($ns) {
  switch($ns) {
    case 'contacts':
      $elements = array(
        'contactNote' => array(),
        'emails' => array(),
        'contactNote' => array(),
        'contactNote' => array(),
        'contactNote' => array(),
        'contactNote' => array(),
      );
      break;
  }
}

/**
 * Implements hook_form_alter().
 */
function module_name_form_alter(&$form, &$form_state, $form_id) {

}

/**
 *
 * Webform for managing profiles
 */
function bamboo_as_manage_profile_form($form, &$form_state) {

  //left off
  //PROFILE data
  $form['person'] = array(
  //'#type' => 'fieldset',
  //'#title' => t('Profile Information'),
  // retain the contacts index under $form_state['values']
    '#tree' => TRUE,
  );
  $form['person']['profileInformation'] = array(
      '#type' => 'textfield',
      '#title' => t('Profile Information'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['interests'] = array(
      '#type' => 'textfield',
      '#title' => t('Intrests'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['expertises'] = array(
      '#type' => 'textfield',
      '#title' => t('Areas of Expertise'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['externalAffiliations'] = array(
      '#type' => 'textfield',
      '#title' => t('External Affiliations'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['preferredLanguage'] = array(
      '#type' => 'textfield',
      '#title' => t('Preferred Language'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['languageUsedInScholarships'] = array(
      '#type' => 'textfield',
      '#title' => t('Language Used in Scholarships'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['otherProfiles-profileName'] = array(
      '#type' => 'textfield',
      '#title' => t('Profile Name'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  $form['person']['otherProfiles-profileUrl'] = array(
      '#type' => 'textfield',
      '#title' => t('Profile URL'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );

  //CONTACT data
  $form['contacts'] = array(
  //'#type' => 'fieldset',
  //'#title' => t('Contact Information'),
  // retain the contacts index under $form_state['values']
    '#tree' => TRUE,
  );

  $form['contacts']['contactNote'] = array(
      '#type' => 'textfield',
      '#title' => t('Contact Note'),
      '#required' => FALSE,
      '#default_value' => (isset($form_state['storage']['contacts']['contactNote'])) ? $form_state['storage']['contacts']['contactNote'] : NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['contactNote'])) {
   $form['contacts']['contactNote']['#value'] = $form_state['values']['contacts']['contactNote'];
   }
   */
  $form['contacts']['emails-email'] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#required' => false, //true
      '#default_value' => 'bwood',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (!isset($form['contacts']['emails-email']['#value']) && isset($form_state['values']['contacts']['emails-email'])) {
   $form['contacts']['emails-email']['#value'] = $form_state['values']['contacts']['emails-email'];
   }
   */

  $form['contacts']['partNames-HONORIFIC_PREFIX'] = array(
      '#type' => 'textfield',
      '#title' => t("Prefix"),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['partNames-HONORIFIC_PREFIX'])) {
   $form['contacts']['partNames-HONORIFIC_PREFIX']['#value'] = $form_state['values']['contacts']['partNames-HONORIFIC_PREFIX'];
   }
   */
  $form['contacts']['partNames-NAME_GIVEN'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#required' => false, //true
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['partNames-NAME_GIVEN'])) {
   $form['contacts']['partNames-NAME_GIVEN']['#value'] = $form_state['values']['contacts']['partNames-NAME_GIVEN'];
   }
   */

  $form['contacts']['partNames-NAME_FAMILY_PATERNAL'] = array(
      '#type' => 'textfield',
      '#title' => t('Family Name Paternal'),
      '#required' => false, //true
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['partNames-NAME_FAMILY_PATERNAL'])) {
   $form['contacts']['partNames-NAME_FAMILY_PATERNAL']['#value'] = $form_state['values']['contacts']['partNames-NAME_FAMILY_PATERNAL'];
   }
   */

  $form['contacts']['partNames-NAME_FAMILY_MATERNAL'] = array(
      '#type' => 'textfield',
      '#title' => t('Family Name Maternal'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['partNames-NAME_FAMILY_MATERNAL'])) {
   $form['contacts']['partNames-NAME_FAMILY_MATERNAL']['#value'] = $form_state['values']['contacts']['partNames-NAME_FAMILY_MATERNAL'];
   }
   */

  $form['contacts']['partNames-HONORIFIC_SUFFIX'] = array(
      '#type' => 'textfield',
      '#title' => t('Suffix'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['partNames-NAME_HONORIFIC_SUFFIX'])) {
   $form['contacts']['partNames-NAME_HONORIFIC_SUFFIX']['#value'] = $form_state['values']['contacts']['partNames-NAME_HONORIFIC_SUFFIX'];
   }
   */

  $form['contacts']['telephones-Type'] = array(
      '#type' => 'textfield',
      '#title' => t('Phone Type'),
      '#required' => FALSE,
      '#default_value' => 'VOICE',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['telephones-Type'])) {
   $form['contacts']['telephones-Type']['#value'] = $form_state['values']['contacts']['telephones-Type'];
   }
   */

  $form['contacts']['telephones-Number'] = array(
      '#type' => 'textfield',
      '#title' => t('Phone Number'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['telephones-Number'])) {
   $form['contacts']['telephones-Number']['#value'] = $form_state['values']['contacts']['telephones-Number'];
   }
   */
  $form['contacts']['telephones-locationType'] = array(
      '#type' => 'textfield',
      '#title' => t('Phone Location Type'),
      '#required' => FALSE,
      '#default_value' => 'WORK',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['telephones-locationType'])) {
   $form['contacts']['telephones-locationType']['#value'] = $form_state['values']['contacts']['telephones-locationType'];
   }
   */
  $form['contacts']['iMs-instantMessagingType'] = array(
      '#type' => 'textfield',
      '#title' => t('Instant Messaging Service'),
      '#required' => FALSE,
      '#default_value' => 'SKYPE',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['iMs-instantMessagingType'])) {
   $form['contacts']['iMs-instantMessagingType']['#value'] = $form_state['values']['contacts']['iMs-instantMessagingType'];
   }
   */
  $form['contacts']['iMs-account'] = array(
      '#type' => 'textfield',
      '#title' => t('Instant Messaging Account'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['iMs-account'])) {
   $form['contacts']['iMs-account']['#value'] = $form_state['values']['contacts']['iMs-account'];
   }
   */
  $form['contacts']['iMs-locationType'] = array(
      '#type' => 'textfield',
      '#title' => t('Instant Messaging Location Type'),
      '#required' => FALSE,
      '#default_value' => 'WORK',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['iMs-locationType'])) {
   $form['contacts']['iMs-locationType']['#value'] = $form_state['values']['contacts']['iMs-locationType'];
   }
   */
  $form['contacts']['addresses-streetAddress1'] = array(
      '#type' => 'textfield',
      '#title' => t('Street Address 1'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-streetAddress1'])) {
   $form['contacts']['addresses-streetAddress1']['#value'] = $form_state['values']['contacts']['addresses-streetAddress1'];
   }
   */
  $form['contacts']['addresses-streetAddress2'] = array(
      '#type' => 'textfield',
      '#title' => t('Street Address 2'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-streetAddress2'])) {
   $form['contacts']['addresses-streetAddress2']['#value'] = $form_state['values']['contacts']['addresses-streetAddress2'];
   }
   */
  $form['contacts']['addresses-streetAddress3'] = array(
      '#type' => 'textfield',
      '#title' => t('Street Address 3'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-streetAddress3'])) {
   $form['contacts']['addresses-streetAddress3']['#value'] = $form_state['values']['contacts']['addresses-streetAddress3'];
   }
   */

  $form['contacts']['addresses-locality'] = array(
      '#type' => 'textfield',
      '#title' => t('Locality'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-locality'])) {
   $form['contacts']['addresses-locality']['#value'] = $form_state['values']['contacts']['addresses-locality'];
   }
   */
  $form['contacts']['addresses-region'] = array(
      '#type' => 'textfield',
      '#title' => t('Region'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-region'])) {
   $form['contacts']['addresses-region']['#value'] = $form_state['values']['contacts']['addresses-region'];
   }
   */
  $form['contacts']['addresses-postalCode'] = array(
      '#type' => 'textfield',
      '#title' => t('Postal Code'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-postalCode'])) {
   $form['contacts']['addresses-postalCode']['#value'] = $form_state['values']['contacts']['addresses-postalCode'];
   }
   */
  $form['contacts']['addresses-country'] = array(
      '#type' => 'textfield',
      '#title' => t('Country'),
      '#required' => FALSE,
      '#default_value' => NULL,
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-country'])) {
   $form['contacts']['addresses-country']['#value'] = $form_state['values']['contacts']['addresses-country'];
   }
   */
  $form['contacts']['addresses-locationType'] = array(
      '#type' => 'textfield',
      '#title' => t('Location Type'),
      '#required' => FALSE,
      '#default_value' => 'WORK',
      '#description' => "",
      '#size' => 20,
      '#maxlength' => 255,
  );
  /*
   if (isset($form_state['values']['contacts']['addresses-locationType'])) {
   $form['contacts']['addresses-locationType']['#value'] = $form_state['values']['contacts']['addresses-locationType'];
   }
   */

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Update',
  );

  return $form;

}


/**
 *
 * Validate the manage profile form submission

 //TODO: Add validation: trim addslashes
 function bamboo_as_manage_profile_form_validate($form, &$form_state) {

 }
 */

function bamboo_as_contact_form2xml(&$form_state) {
  $namespace = 'contacts';

  $xml = XMLDECLARATION;
  $xml .= '<contacts:bambooContact xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact" >' . "\n";

  //while (list($k, $v) = each($form_state['complete form']['contacts'])) {
  while (list($k, $v) = each($form_state['values']['contacts']))  {
    //if (!is_array($c) || !isset($c['#name'])) continue;
    $parts = explode('-', $k);


    switch ($parts[0]) {
      case "contactNote":
        $xml .= "<$namespace:contactNote>" . $v . "</$namespace:contactNote>\n";
        break;
      case "emails":

        $xml .= "<$namespace:emails>\n";
        $xml .= "<$namespace:email>" . $v . "</$namespace:email>\n";
        $xml .= "</$namespace:emails>\n";

        break;
      case "partNames":

        $xml .= "<$namespace:partNames>\n";
        $xml .= "<$namespace:partNameType>" . $parts[1] . "</$namespace:partNameType>\n";
        $xml .= "<$namespace:partNameContent>" . $v . "</$namespace:partNameContent>\n";
        $xml .= "<$namespace:partNameLang>eng</$namespace:partNameLang>\n";
        $xml .= "</$namespace:partNames>\n";

        break;
      case "telephones":

        switch($parts[1]) {
          case "Type":
            $tel_type = "<$namespace:telephoneType>" . $v . "</$namespace:telephoneType>\n";
            break;
          case "Number":
            $tel_number = "<$namespace:telephoneNumber>" . $v . "</$namespace:telephoneNumber>\n";
            break;
          case "locationType":
            $tel_locationType = "<$namespace:locationType>" .  $v . "</$namespace:locationType>\n";
            break;
        }

        if (isset($tel_type) && isset($tel_number) && isset($tel_locationType)) {
          $xml .= "<$namespace:telephones>\n";
          $xml .= $tel_type;
          $xml .= $tel_number;
          $xml .= $tel_locationType;
          $xml .= "</$namespace:telephones>\n";
        }


        break;
      case "iMs":

        switch($parts[1]) {
          case "instantMessagingType":
            $im_type = "<$namespace:instantMessagingType>" . $v . "</$namespace:instantMessagingType>\n";
            break;
          case "account":
            $im_account = "<$namespace:account>" . $v . "</$namespace:account>\n";
            break;
          case "locationType":
            $im_locationType = "<$namespace:locationType>" . $v . "</$namespace:locationType>\n";
            break;

        }

        if (isset($im_type) && isset($im_account) && isset($im_locationType)) {
          $xml .= "<$namespace:iMs>\n";
          $xml .= $im_type;
          $xml .= $im_account;
          $xml .= $im_locationType;
          $xml .= "</$namespace:iMs>\n";
        }

        break;

      case "addresses":
        switch ($parts[1]) {
          case "streetAddress1":
            $add_sa1 = "<$namespace:streetAddress1>" . $v . "</$namespace:streetAddress1>\n";
            break;
          case "streetAddress2":
            $add_sa2 = "<$namespace:streetAddress2>" . $v . "</$namespace:streetAddress2>\n";
            break;
          case "streetAddress3":
            $add_sa3 = "<$namespace:streetAddress3>" . $v . "</$namespace:streetAddress3>\n";
            break;
          case "locality":
            $add_locality = "<$namespace:locality>" . $v . "</$namespace:locality>\n";
            break;
          case "region":
            $add_region = "<$namespace:region>" . $v . "</$namespace:region>\n";
            break;
          case "postalCode":
            $add_postalCode = "<$namespace:postalCode>" . $v . "</$namespace:postalCode>\n";
            break;
          case "country":
            $add_country = "<$namespace:country>" . $v . "</$namespace:country>\n";
            break;
          case "locationType":
            $add_locationType = "<$namespace:locationType>" . $v . "</$namespace:locationType>\n";
            break;
        }

        if (isset($add_sa1) && isset($add_sa2) && isset($add_sa3) && isset($add_locality) && isset($add_region) && isset($add_postalCode) && isset($add_country) && isset($add_locationType)) {
          $xml .= "<$namespace:addresses>\n";
          $xml .= $add_sa1;
          $xml .= $add_sa2;
          $xml .= $add_sa3;
          $xml .= $add_locality;
          $xml .= $add_region;
          $xml .= $add_postalCode;
          $xml .= $add_country;
          $xml .= $add_locationType;
          $xml .= "</$namespace:addresses>\n";
        }

        break;
    }
  }
  $xml .= '</contacts:bambooContact>';
  return $xml;
}

function bamboo_as_profile_form2xml(&$form_state, $contact_id) {
  $namespace = 'person';

  $xml = XMLDECLARATION;
  $xml .= '<person:bambooPerson xmlns:person="http://projectbamboo.org/bsp/BambooPerson" xmlns:xs="http://www.w3.org/2001/XMLSchema">' . "\n";
  $xml .= '<person:bambooProfile person:confidential="false" person:primary="false" xmlns:contacts="http://projectbamboo.org/bsp/services/core/contact" xmlns:person="http://projectbamboo.org/bsp/BambooPerson">' . "\n";
  $xml .= '<contacts:bambooContact>' . "\n";
  $xml .= "<contacts:contactId>$contact_id</contacts:contactId>\n";
  $xml .= '</contacts:bambooContact>' . "\n";

  //while (list($k, $v) = each($form_state['complete form']['contacts'])) {
  while (list($k, $v) = each($form_state['values']['person']))  {
    //if (!is_array($c) || !isset($c['#name'])) continue;
    $parts = explode('-', $k);
    switch ($parts[0]) {
      case "profileInformation":
      case "externalAffiliations":
      case "preferredLanguage":
      case "languageUsedInScholarships":
        $xml .= "<$namespace:" . $parts[0] . ">" . $v . "</$namespace:" . $parts[0] . ">\n";
        break;
      case "interests":
      case "expertises":
        $singular = trim($parts[0], "s");
        $xml .= "<$namespace:" . $parts[0] . ">\n";
        $xml .= "<$namespace:$singular>" . $v . "</$namespace:$singular>\n";
        $xml .= "</$namespace:" . $parts[0] . ">\n";
        break;
      case "otherProfiles":
        $op_children[] = "<$namespace:" . $parts[1] . ">" . $v . "</$namespace:".  $parts[1] .">";
        //number of op children hard coded!
        if (count($op_children) == 2) {
          $xml .= "<$namespace:otherProfiles>\n";
          $xml .= implode("\n", $op_children);
          $xml .= "</$namespace:otherProfiles>\n";
        }
        break;
    }
  }
  $xml .= "</person:bambooProfile>\n";
  $xml .= "</person:bambooPerson>\n";
  return $xml;
}

/**
 *
 * Update the form fields with the values that now exist in BSP
 * @param unknown_type $form_state
 */
function bamboo_as_contact_xml2form($form, &$form_state, $contact_id) {
  //Read contact

  $xml = bamboo_as_contact_form2xml($form_state);
  $url = BSP_ROOT . "contacts/$contact_id";
  $personRest = new REST_client($url);
  $headers = bamboo_as_get_headers();
  $result = $personRest->doRequest($url, 'GET', null, null, null, $headers);
  if ($result->code != 200) {
    drupal_set_message('Could not read contact record: ' . $result->code, 'warning');
    return;
  }
  $sx_contact = simplexml_load_string($result->body);
  $ns = $sx_contact->getDocNamespaces();
  bamboo_as_simplexml_error($sx_contact);
  $contact = $sx_contact->children($ns['contacts']);


  $form_state['storage']['contacts']['contactNote'] = "diff val";
  /*

  foreach($contact as $k => $v) {
  switch($k) {
  case "contactNote":
  $form_state['values']['contacts'][$k] = (string) $v;
  break;
  case "emails":
  $form_state['values']['contacts']["$k-email"] = (string) $v->email;
  break;
  /*
  case "":
  break;
  case "":
  break;
  case "":
  break;
  case "":
  break;

  }
  }

  */
  $x=1;
}

/**
 *
 * Process the manage profile form submission
 */
function bamboo_as_manage_profile_form_submit($form, &$form_state) {
  //make $form_state available to the form builder funtion (bamboo_as_manage_profile_form) when it is rebuilt.
  $form_state['rebuild'] = TRUE;

  // Create bpid
  bamboo_as_create_identity();
  // loads bpid from $_SESSION
  $headers = bamboo_as_get_headers();

  // Create contact
  $xml = bamboo_as_contact_form2xml($form_state);
  $url = BSP_ROOT . 'contacts';
  $personRest = new REST_client($url);
  $result = $personRest->doRequest($url, 'POST', $xml, CONTENT_TYPE, null, $headers);
  if ($result->code != 201) {
    drupal_set_message('Could not create contact record: ' . $result->code, 'error');
    if (DEBUG) {
      drupal_set_message($result->body, 'error');
      drupal_set_message('<pre>' . htmlentities($xml) . "</pre>", 'error');
    }

  }
  else {
    // The uuid is the last element in the location URL
    $pieces = explode('/', $result->location);
    $contact_id = array_pop($pieces);
    //TODO How important is this: when would the value that gets written to bsp <> the value just submitted?
    // Update the form with the values from BSP
    /*
    problem:
    1. enter email
    2. submit and get form again
    3. change email
    4. submit and get form again
    email was changed back to the #2 value
    the new value submitted was changed to old value before it got to submit()
    */
    //bamboo_as_contact_xml2form($form, $form_state, $contact_id);
    if (DEBUG) {
      drupal_set_message("Contact id: $contact_id");
      drupal_set_message('<pre>' . htmlentities($xml) . "</pre>", 'status');
    }

    // Create profile
    $xml = bamboo_as_profile_form2xml($form_state, $contact_id);
    $url = BSP_ROOT . 'persons/' . $_SESSION['bpid'] . '/profiles';
    $personRest = new REST_client($url);
    $result = $personRest->doRequest($url, 'POST', $xml, CONTENT_TYPE, null, $headers);
    if ($result->code != 201) {
      drupal_set_message('Could not create profile record: ' . $result->code, 'error');
      if (DEBUG) {
        drupal_set_message($result->body, 'error');
        drupal_set_message('<pre>' . htmlentities($xml) . "</pre>", 'status', 'error');
      }

    }
    else {
      // The uuid is the last element in the location URL
      $pieces = explode('/', $result->location);
      $profile_id = array_pop($pieces);
      if (DEBUG) {
        drupal_set_message("Profile id: $profile_id");
        drupal_set_message('<pre>' . htmlentities($xml) . "</pre>", 'status');
      }
    }
  }
}



/**
 * simplexml errors
 */
function bamboo_as_simplexml_error($sx_object) {
  //if ($sx_object === FALSE) {
  $msg = NULL;
  foreach(libxml_get_errors() as $error) {
    $msg .= "\t" . $error->message;
  }
  if (strlen($msg) !== 0)  drupal_set_message($msg, 'warning');
  //}
}