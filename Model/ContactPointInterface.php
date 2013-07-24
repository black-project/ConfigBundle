<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Model;

/**
 * Class ContactPointInterface
 *
 * @package Black\Bundle\ConfigBundle\Model
 */
interface ContactPointInterface
{
    /**
     * Set the Contact Point Id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set the Contact Type
     *
     * @param $contactType
     *
     * @return mixed
     */
    public function setContactType($contactType);

    /**
     * Return the Contact Type
     *
     * @return mixed
     */
    public function getContactType();

    /**
     * Set the Email
     *
     * @param $email
     *
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Get the Email
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set the Telephone number
     *
     * @param $telephone
     *
     * @return mixed
     */
    public function setTelephone($telephone);

    /**
     * Return the Telephone number
     *
     * @return mixed
     */
    public function getTelephone();

    /**
     * Set the Mobile number
     *
     * @param $mobile
     *
     * @return mixed
     */
    public function setMobile($mobile);

    /**
     * Get the Telephone number
     *
     * @return mixed
     */
    public function getMobile();
}
