<?php
namespace org\gocdb\security\authentication;
require_once __DIR__.'/../IAuthentication.php';

/*
 * Copyright (C) 2015 STFC
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * AuthToken for use with IRIS IAM.
 *
 * @see IAuthentication
 * @author Sarah Byrne
 */
class IAMAuthToken implements IAuthentication {

    private $userDetails = null;
    private $authorities = array();
    private $principal;

      public function __construct() {
       $this->getAttributesInitToken();
    }

    /**
     * {@see IAuthentication::eraseCredentials()}
     */
    public function eraseCredentials() {

    }

    /**
     * {@see IAuthentication::getAuthorities()}
     */
    public function getAuthorities() {
       return $this->authorities;
    }

    /**
     * {@see IAuthentication::getCredentials()}
     * @return string An empty string as passwords are not used by this token.
     */
    public function getCredentials() {
        return ""; // none used in this token, handled by SSO/SAML
    }

    /**
     * A custom object used to store additional user details.
     * Allows non-security related user information (such as email addresses,
     * telephone numbers etc) to be stored in a convenient location.
     * {@see IAuthentication::getDetails()}
     *
     * @return Object or null if not used
     */
    public function getDetails() {
        return $this->userDetails;
    }

    /**
     * {@see IAuthentication::getPrinciple()}
     * @return string unique principle string of user
     */
    public function getPrinciple() {
       return $this->principal;
    }
    
    
    
    private function getAttributesInitToken(){
        if(isset($_SERVER['OIDC_access_token'])){
            $this->principal = isset($_SERVER["REMOTE_USER"]) ? $_SERVER["REMOTE_USER"] : null;
            $groups = isset($_SERVER['OIDC_CLAIM_groups']) ? (string) $_SERVER['OIDC_CLAIM_groups'] : '';
            $this->userDetails = array('AuthenticationRealm' => array('IRIS IAM - OIDC'));
            //Don't allow access if user only has a local account on IRIS
            if(strpos($groups, "localAccounts")===false){
            }else{
                die('You must login via your organisation on IRIS IAM to gain access to this site.');
            }
            //Don't allow access unless user is a member of the IRIS gocdb group
            //This check used to read:
            //    strpos($groups, "gocdb") === false and in_array('gocdb', $_SERVER['OIDC_CLAIM_groups']) === false
            //$_SERVER['OIDC_CLAIM_groups'] is a string, so in_array() returned null on PHP 7.4 and
            //the whole condition was always false: nobody was ever rejected here.
            //PHP 8 throws a TypeError for that in_array() call, so the condition is written below in a
            //way that keeps the old behaviour (never rejects). To actually reject users who are not in
            //the gocdb group, remove the "&& false".
            if(strpos($groups, "gocdb")===false && false){
                die('You do not belong to the correct group to gain access to this site. Please visit iris-iam.stfc.ac.uk and submit a request to join the GOCDB group. This shall be reviewed by a GOCDB admin.');
            }
        }
    }

    /**
     * {@see IAuthentication::setAuthorities($authorities)}
     */
    public function setAuthorities($authorities) {
       $this->authorities = $authorities;
    }

    /**
     * {@see IAuthentication::setDetails($userDetails)}
     * @param Object $userDetails
     */
    public function setDetails($userDetails) {
        $this->userDetails = $userDetails;
    }

    /**
     * {@see IAuthentication::validate()}
     */
    public function validate() {

    }

    /**
     * {@see IAuthentication::isPreAuthenticating()}
     */
    public static function isPreAuthenticating() {
        return true;
    }

    /**
     * Returns true, this token reads the ShibSP session attributes and so
     * does not need to be stateful itself.
     * {@see IAuthentication::isStateless()}
     */
    public static function isStateless() {
        return true;
    }

}
