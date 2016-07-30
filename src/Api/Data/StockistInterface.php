<?php
/**
 * Limesharp_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Limesharp
 * @package   Limesharp_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */
namespace Limesharp\Stockists\Api\Data;

/**
 * @api
 */
interface StockistInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const STOCKIST_ID         = 'stockist_id';
    const NAME                = 'name';
    const ADDRESS             = 'address';
    const CITY                = 'city';
    const POSTCODE            = 'postcode';
    const REGION              = 'region';
    const EMAIL               = 'email';
    const PHONE               = 'phone';
    const LATITUDE            = 'latitude';
    const LONGITUDE           = 'longitude';
    const LINK                = 'link';
    const STATUS              = 'status';
    const TYPE                = 'type';
    const COUNTRY             = 'country';
    const IMAGE               = 'image';
    const CREATED_AT          = 'created_at';
    const UPDATED_AT          = 'updated_at';
    const STORE_ID            = 'store_id';


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get store url
     *
     * @return string
     */
    public function getLink();
    
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress();
    
    /**
     * Get city
     *
     * @return string
     */
    public function getCity();
    
    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode();
    
    /**
     * Get region
     *
     * @return string
     */
    public function getRegion();
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();
    
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();
    
    /**
     * Get image
     *
     * @return string
     */
    public function getImage();
    
    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude();
    
    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude();

    /**
     * Get is active
     *
     * @return bool|int
     */
    public function getStatus();

    /**
     * Get type
     *
     * @return int
     */
    public function getType();

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry();

    /**
     * set id
     *
     * @param $id
     * @return StockistInterface
     */
    public function setId($id);

    /**
     * set name
     *
     * @param $name
     * @return StockistInterface
     */
    public function setName($name);

    /**
     * set link
     *
     * @param $link
     * @return StockistInterface
     */
    public function setLink($link);
    
    /**
     * set image
     *
     * @param $image
     * @return AuthorInterface
     */
    public function setImage($image);
    
    /**
     * set address
     *
     * @param $address
     * @return StockistInterface
     */
    public function setAddress($address);

    /**
     * set city
     *
     * @param $city
     * @return StockistInterface
     */
    public function setCity($city);
    
    /**
     * set postcode
     *
     * @param $postcode
     * @return StockistInterface
     */
    public function setPostcode($postcode);

    /**
     * set region
     *
     * @param $region
     * @return StockistInterface
     */
    public function setRegion($region);

    /**
     * set email
     *
     * @param $email
     * @return StockistInterface
     */
    public function setEmail($email);
    
    /**
     * set phone
     *
     * @param $phone
     * @return StockistInterface
     */
    public function setPhone($phone);

    /**
     * set latitude
     *
     * @param $latitude
     * @return StockistInterface
     */
    public function setLatitude($latitude);
    
    /**
     * set longitude
     *
     * @param $longitude
     * @return StockistInterface
     */
    public function setLongitude($longitude);

    /**
     * Set status
     *
     * @param $status
     * @return StockistInterface
     */
    public function setStatus($status);

    /**
     * set type
     *
     * @param $type
     * @return StockistInterface
     */
    public function setType($type);

    /**
     * Set country
     *
     * @param $country
     * @return StockistInterface
     */
    public function setCountry($country);

    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * set created at
     *
     * @param $createdAt
     * @return StockistInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * set updated at
     *
     * @param $updatedAt
     * @return StockistInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @param $storeId
     * @return StockistInterface
     */
    public function setStoreId($storeId);

    /**
     * @return int[]
     */
    public function getStoreId();

}
