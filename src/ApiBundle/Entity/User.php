<?php
namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ApiBundle\Entity\Repository\UserRepo") 
 * @UniqueEntity(fields="username", message="Этот логин уже используется")
 * @UniqueEntity(fields="email", message="Этот адрес e-mail уже используется")
 */
class User implements AdvancedUserInterface, \Serializable
{    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="логин должен быть заполнен")
     * @Assert\Length(min=3, minMessage="логин должен иметь минимум 3 символа")
     * @Assert\Length(max=25, maxMessage="логин должен иметь максимум 25 символов")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)     
     * @Assert\Length(min=3, minMessage="пароль должен иметь минимум 3 символа")
     * @Assert\Length(max=64, maxMessage="пароль должен иметь максимум 64 символа") 
     */
    private $password;
    
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
     /**
     * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
     */
    private $firstname;
    
     /**
     * @ORM\Column(name="secondname", type="string", length=100, nullable=true)
     */
    private $secondname;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    
    public function __construct() 
    {    
        
        $this->createdAt = new \DateTime('now');       
        $this->IsActive = FALSE;    
        $this->firstname = null;
        $this->secondname = null;
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ) = unserialize($serialized);
    }

    
    // for inplementation UserInterface
    public function getRoles()
    {
        $roles = $this->getUserRoles()->toArray();          
        return $roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;        
        return $this;
    }
    
    /**
     * Add userRole
     *
     * @param \ApiBundle\Entity\Role $userRole
     *
     * @return User
     */
    public function addUserRole(\ApiBundle\Entity\Role $userRole)
    {
        $this->userRoles[] = $userRole;
        return $this;
    }

    /**
     * Remove userRole
     *
     * @param \ApiBundle\Entity\Role $userRole
     */
    public function removeUserRole(\ApiBundle\Entity\Role $userRole)
    {
        $this->userRoles->removeElement($userRole);
    }

    /**
     * Get userRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
       
        return $this->userRoles;
    }
    
    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {       
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }
   
    public function eraseCredentials()
    {     
    }
    
    //for inplementation AdvancedUserInterface
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set secondname
     *
     * @param string $secondname
     *
     * @return User
     */
    public function setSecondname($secondname)
    {
        $this->secondname = $secondname;

        return $this;
    }

    /**
     * Get secondname
     *
     * @return string
     */
    public function getSecondname()
    {
        return $this->secondname;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
