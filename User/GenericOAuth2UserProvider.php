<?php

namespace Kanboard\Plugin\OAuth2\User;

use Kanboard\Core\Base;
use Kanboard\Core\User\UserProviderInterface;
use Pimple\Container;

/**
 * GenericOAuth2UserProvider
 *
 * @package  Kanboard\User
 * @author   Frederic Guillot
 */
class GenericOAuth2UserProvider extends Base implements UserProviderInterface
{
    /**
     * @var array
     */
    protected $userData = array();

    /**
     * Constructor
     *
     * @access public
     * @param  Container $container
     * @param  array $user
     */
    public function __construct(Container $container, array $user)
    {
        parent::__construct($container);
        $this->userData = $user;
    }

    /**
     * Return true to allow automatic user creation
     *
     * @access public
     * @return boolean
     */
    public function isUserCreationAllowed()
    {
        return $this->configModel->get('oauth2_account_creation', 0) == 1;
    }

    /**
     * Get username
     *
     * @access public
     * @return string
     */
    public function getUsername()
    {
        if ($this->isUserCreationAllowed()) {
            return $this->getKey('oauth2_key_username');
        }

        return '';
    }

    /**
     * Get external id column name
     *
     * @access public
     * @return string
     */
    public function getExternalIdColumn()
    {
        return 'oauth2_user_id';
    }

    /**
     * Get extra user attributes
     *
     * @access public
     * @return array
     */
    public function getExtraAttributes()
    {
        if ($this->isUserCreationAllowed()) {
            return array(
                'is_ldap_user' => 1,
                'disable_login_form' => 1,
            );
        }

        return array();
    }

    /**
     * Get internal id
     *
     * If a value is returned the user properties won't be updated in the local database
     *
     * @access public
     * @return integer
     */
    public function getInternalId()
    {
        return '';
    }

    /**
     * Get external id
     *
     * @access public
     * @return string
     */
    public function getExternalId()
    {
        return $this->getKey('oauth2_key_user_id');
    }

    /**
     * Get user role
     *
     * Return an empty string to not override role stored in the database
     *
     * @access public
     * @return string
     */
    public function getRole()
    {
        return '';
    }

    /**
     * Get user full name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->getKey('oauth2_key_name');
    }

    /**
     * Get user email
     *
     * @access public
     * @return string
     */
    public function getEmail()
    {
        return $this->getKey('oauth2_key_email');
    }

    /**
     * Check if group is in filter
     *
     * @access protected
     * @param string $group
     * @return boolean
     */
    protected function isGroupInFilter(string $group, array $filter) 
    {
        if (empty($filter)) {
            $this->logger->debug('OAuth2: No group specified in filter. All provided groups will be used.');
            return true;
        } else {
            if (in_array($group, $filter)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get external group ids
     *
     * A synchronization is done at login time,
     * the user will be member of those groups if they exists in the database
     *
     * @access public
     * @return string[]
     */
    public function getExternalGroupIds()
    {
        $key = 'oauth2_key_groups';
        
        if (empty($this->configModel->get($key))) {
            return array();
        }
        
        $groups = $this->getKey($key);

        if (empty($groups)) {
            $this->logger->debug('OAuth2: '.$this->getUsername().' has no groups');
            return array();
        }

        $groups = array_unique($groups);
        $this->logger->debug('OAuth2: '.$this->getUsername().' groups are '. join(',', $groups));

        $filteredGroups = array();
        $groupFilter = explode(',',$this->configModel->get('oauth2_key_group_filter'));

        foreach ($groups as $group) {
            if ( $this->isGroupInFilter($group, $groupFilter)) {
                $this->groupModel->getOrCreateExternalGroupId($group, $group);
                array_push($filteredGroups, $group);
            } else {
                $this->logger->debug('OAuth2: '.$group.' will be ignored.');
            }
        }

        return $filteredGroups;
    }

    /**
     * Return true if the account creation is allowed according to the settings
     *
     * @access public
     * @param array $profile
     * @return bool
     */
    public function isAccountCreationAllowed(array $profile)
    {
        if ($this->isUserCreationAllowed()) {
            $domains = $this->configModel->get('oauth2_email_domains');

            if (! empty($domains)) {
                return $this->validateDomainRestriction($profile, $domains);
            }

            return true;
        }

        return false;
    }

    /**
     * Validate domain restriction
     *
     * @access private
     * @param  array  $profile
     * @param  string $domains
     * @return bool
     */
    public function validateDomainRestriction(array $profile, $domains)
    {
        foreach (explode(',', $domains) as $domain) {
            $domain = trim($domain);

            if (strpos($profile['email'], $domain) > 0) {
                return true;
            }
        }

        return false;
    }

    protected function getKey($key)
    {
        $key   = explode('.', $this->configModel->get($key));
        $value = $this->userData;
        foreach ($key as $k) {
            $value = $value[$k];
        }
        return ! empty($key) && isset($value) ? $value : '';
    }
}
