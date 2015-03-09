<?php

namespace JG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Doctrine\Common\Collections\Collection;
use Serializable;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User extends BaseUser implements \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"})
     */
    protected $email;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"})
     * @ORM\Column(name="firstname", type="string", length=64)
     */
    protected $firstName;

    /**
     * @var string
     * @Assert\NotBlank(groups={"registration"})
     * @ORM\Column(name="lastname", type="string", length=64)
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated", type="datetime", nullable=true)
     */
    protected $lastUpdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @var string
     *
     */
    protected $salt;

	 /**
	  * @ORM\ManyToMany(targetEntity="JS\UserBundle\Entity\Group", inversedBy="users")
	  * @ORM\JoinTable(name="user_guild",
	  *		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
	  *		inverseJoinColumns={@ORM\JoinColumn(name="guild_id", referencedColumnName="guild_id")}
	  * )
	  */
	 protected $groups;

	/**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     * @ORM\JoinTable(name="user_role",
     *		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
	 *		inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="role_id")}
	 * )
     */
    protected $roles;

    /**
     *@ORM\Column(name="pin", type="integer", length=4)
     *
     */
    protected $pin;

    /**
     *@ORM\Column(name="employee_id", type="integer")
     *
     */
    protected $employeeId;

    /**
	  * @ORM\ManyToMany(targetEntity="JS\UserBundle\Entity\Badge", inversedBy="users")
	  * @ORM\JoinTable(name="users_badges",
	  *		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
	  *		inverseJoinColumns={@ORM\JoinColumn(name="badge_id", referencedColumnName="badge_id")}
	  * )
	  */
    protected $badges;

	public function __construct()
	{
		parent::__construct();
		$this->roles = new ArrayCollection();
		$this->groups = new ArrayCollection();
        $this->badges = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
		//in our case username will be same as email
		$this->username = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ludDtm
     *
     * @param \DateTime $lastUpdated
     * @return User
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get ludDtm
     *
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set crtDtm
     *
     * @param \DateTime $crtDtm
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get crtDtm
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

	public function getUserRoles()
	{
		return $this->roles->toArray();
	}

	/**
	 * This will give all the roles user, including Group roles for groups user belongs in
	 * @return type
	 */
	public function getRoles()
	{
		$roles = $this->roles->toArray();
		$groups = $this->groups->toArray();
		foreach ($groups as $group)
		{
			/* @var $group Group */
			$roles = array_merge($roles, $group->getRoles()->toArray());
		}
		return array_merge( $roles, array( new Role( parent::ROLE_DEFAULT) ) );
	}

	/**
     * Returns the true ArrayCollection of Roles.
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getRolesCollection()
    {
        return $this->roles;
    }

	/**
     * Pass a string, get the desired Role object or null.
     * @param string $role
     * @return Role|null
     */
    public function getRole( $role )
    {
        foreach ( $this->getRoles() as $roleItem )
        {
            if ( $role == $roleItem->getRole() )
            {
                return $roleItem;
            }
        }
        return null;
    }

    /**
     * Pass a string, checks if we have that Role. Same functionality as getRole() except returns a real boolean.
     * @param string $role
     * @return boolean
     */
    public function hasRole( $role )
    {
        if ( $this->getRole( $role ) )
        {
            return true;
        }
        return false;
    }

    /**
     * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
     * @throws Exception
     * @param Role $role
     */
    public function addRole( $role )
    {
        if ( !$role instanceof Role )
        {
            throw new \Exception( "addRole takes a Role object as the parameter" );
        }

        if ( !$this->hasRole( $role->getRole() ) )
        {
            $this->roles->add( $role );
        }
    }

    /**
     * Pass a string, remove the Role object from collection.
     * @param string $role
     */
    public function removeRole( $role )
    {
        $roleElement = $this->getRole( $role );
        if ( $roleElement )
        {
            $this->roles->removeElement( $roleElement );
        }
    }

    /**
     * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
     * Type hinted array due to interface.
     * @param array $roles Of Role objects.
     */
    public function setRoles( array $roles )
    {
        $this->roles = new ArrayCollection();
        foreach ( $roles as $role )
        {
            $this->addRole( $role );
        }
    }

    /**
     * Directly set the ArrayCollection of Roles. Type hinted as Collection which is the parent of (Array|Persistent)Collection.
     * @param Doctrine\Common\Collections\Collection $role
     */
    public function setRolesCollection( Collection $collection )
    {
        $this->roles = $collection;
    }

    /**
     * Clear current groups for the User and set passed groups
     * @param array $groups Array of Group Entity
     */
    public function setGroups( array $groups )
    {
            $this->groups->clear();
            foreach ( $groups as $group )
            {
                    $this->addGroup($group);
            }
    }

    /**
     * Set pin
     *
     * @param int $pin
     * @return User
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return int
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set e id
     *
     * @param int $employee_id
     * @return User
     */
    public function setEmployeeId($employee_id)
    {
        $this->employeeId = $employee_id;

        return $this;
    }

    public function setBadges(array $badges)
    {
        $this->badges = new ArrayCollection($badges);

        return $this;
    }

    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * Pass a string, get the desired Badge object or null.
     * @param string $badge
     * @return Role|null
     */
    public function getBadge(Badge $badge)
    {
        foreach ( $this->getBadges() as $badgeItem )
        {
            if ( $badge == $badgeItem->getRole() )
            {
                return $badgeItem;
            }
        }
        return null;
    }

    public function hasBadge(Badge $badge)
    {
        if ( $this->getBadge($badge) )
        {
            return true;
        }
        return false;
    }

    /**
     * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
     * @throws Exception
     * @param Role $role
     */
    public function addBadge($badge)
    {
        $this->badges->add($badge);

        return $this;
    }

    /**
     * Pass a string, remove the Role object from collection.
     * @param string $role
     */
    public function removeBadge($badge)
    {
        $this->badges->removeElement($badge);

        return $this;
    }

    /**
     * Get employee id
     *
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->salt,
            $this->password
        ));
    }

    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->salt,
            $this->password
        ) = unserialize($serialized);
    }
}
