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
namespace Limesharp\Stockists\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\Collection\Db;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Limesharp\Stockists\Api\Data\AuthorInterface;
use Limesharp\Stockists\Model\Stores\Url;
use Limesharp\Stockists\Model\ResourceModel\Stores as AuthorResourceModel;
use Limesharp\Stockists\Model\Routing\RoutableInterface;
use Limesharp\Stockists\Model\Source\AbstractSource;


/**
 * @method AuthorResourceModel _getResource()
 * @method AuthorResourceModel getResource()
 */
class Stores extends AbstractModel implements AuthorInterface, RoutableInterface
{
    /**
     * @var int
     */
    const STATUS_ENABLED = 1;
    /**
     * @var int
     */
    const STATUS_DISABLED = 0;
    /**
     * @var Url
     */
    protected $urlModel;
    /**
     * cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'limesharp_stockists';

    /**
     * cache tag
     *
     * @var string
     */
    protected $_cacheTag = 'limesharp_stockists_stores';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'limesharp_stockists_stores';

    /**
     * filter model
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filter;

    /**
     * @var UploaderPool
     */
    protected $uploaderPool;

    /**
     * @var \Limesharp\Stockists\Model\Output
     */
    protected $outputProcessor;

    /**
     * @var AbstractSource[]
     */
    protected $optionProviders;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param Output $outputProcessor
     * @param UploaderPool $uploaderPool
     * @param FilterManager $filter
     * @param Url $urlModel
     * @param array $optionProviders
     * @param array $data
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Output $outputProcessor,
        UploaderPool $uploaderPool,
        FilterManager $filter,
        Url $urlModel,
        array $optionProviders = [],
        array $data = [],
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null
    )
    {
        $this->outputProcessor = $outputProcessor;
        $this->uploaderPool    = $uploaderPool;
        $this->filter          = $filter;
        $this->urlModel        = $urlModel;
        $this->optionProviders = $optionProviders;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(AuthorResourceModel::class);
    }


    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->getData(AuthorInterface::TYPE);
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(AuthorInterface::COUNTRY);
    }

    /**
     * set name
     *
     * @param $name
     * @return AuthorInterface
     */
    public function setName($name)
    {
        return $this->setData(AuthorInterface::NAME, $name);
    }

    /**
     * set type
     *
     * @param $type
     * @return AuthorInterface
     */
    public function setType($type)
    {
        return $this->setData(AuthorInterface::TYPE, $type);
    }


    /**
     * Set country
     *
     * @param $country
     * @return AuthorInterface
     */
    public function setCountry($country)
    {
        return $this->setData(AuthorInterface::COUNTRY, $country);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(AuthorInterface::NAME);
    }

    /**
     * Get url key
     *
     * @return string
     */
    public function getLink()
    {
        return $this->getData(AuthorInterface::LINK);
    }
    
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getData(AuthorInterface::ADDRESS);
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getData(AuthorInterface::CITY);
    }
    
    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->getData(AuthorInterface::POSTCODE);
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->getData(AuthorInterface::REGION);
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(AuthorInterface::EMAIL);
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(AuthorInterface::PHONE);
    }
    
    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->getData(AuthorInterface::LATITUDE);
    }
    
    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->getData(AuthorInterface::LONGITUDE);
    }

    /**
     * Get status
     *
     * @return bool|int
     */
    public function getStatus()
    {
        return $this->getData(AuthorInterface::STATUS);
    }


    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(AuthorInterface::CREATED_AT);
    }

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(AuthorInterface::UPDATED_AT);
    }

    /**
     * set link
     *
     * @param $link
     * @return AuthorInterface
     */
    public function setLink($link)
    {
        return $this->setData(AuthorInterface::LINK, $link);
    }

    /**
     * set address
     *
     * @param $address
     * @return AuthorInterface
     */
    public function setAddress($address)
    {
        return $this->setData(AuthorInterface::ADDRESS, $address);
    }

    /**
     * set city
     *
     * @param $city
     * @return AuthorInterface
     */
    public function setCity($city)
    {
        return $this->setData(AuthorInterface::CITY, $city);
    }

    /**
     * set postcode
     *
     * @param $postcode
     * @return AuthorInterface
     */
    public function setPostcode($postcode)
    {
        return $this->setData(AuthorInterface::POSTCODE, $postcode);
    }

    /**
     * set region
     *
     * @param $region
     * @return AuthorInterface
     */
    public function setRegion($region)
    {
        return $this->setData(AuthorInterface::REGION, $region);
    }

    /**
     * set email
     *
     * @param $email
     * @return AuthorInterface
     */
    public function setEmail($email)
    {
        return $this->setData(AuthorInterface::EMAIL, $email);
    }

    /**
     * set phone
     *
     * @param $phone
     * @return AuthorInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(AuthorInterface::PHONE, $phone);
    }

    /**
     * set latitude
     *
     * @param $latitude
     * @return AuthorInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(AuthorInterface::LATITUDE, $latitude);
    }
    
    /**
     * set longitude
     *
     * @param $longitude
     * @return AuthorInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(AuthorInterface::LONGITUDE, $longitude);
    }

    /**
     * Set status
     *
     * @param $status
     * @return AuthorInterface
     */
    public function setStatus($status)
    {
        return $this->setData(AuthorInterface::STATUS, $status);
    }


    /**
     * set created at
     *
     * @param $createdAt
     * @return AuthorInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(AuthorInterface::CREATED_AT, $createdAt);
    }

    /**
     * set updated at
     *
     * @param $updatedAt
     * @return AuthorInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(AuthorInterface::UPDATED_AT, $updatedAt);
    }


    /**
     * Check if author url key exists
     * return author id if author exists
     *
     * @param string $urlKey
     * @param int $storeId
     * @return int
     */
    public function checkUrlKey($urlKey, $storeId)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $storeId);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @param $storeId
     * @return AuthorInterface
     */
    public function setStoreId($storeId)
    {
        $this->setData(AuthorInterface::STORE_ID, $storeId);
        return $this;
    }

    /**
     * @return array
     */
    public function getStoreId()
    {
        return $this->getData(AuthorInterface::STORE_ID);
    }

    /**
     * sanitize the url key
     *
     * @param $string
     * @return string
     */
    public function formatUrlKey($string)
    {
        return $this->filter->translitUrl($string);
    }

    /**
     * @return mixed
     */
    public function getAuthorUrl()
    {
        return $this->urlModel->getAuthorUrl($this);
    }

    /**
     * @return bool
     */
    public function status()
    {
        return (bool)$this->getStatus();
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getAttributeText($attribute)
    {
        if (!isset($this->optionProviders[$attribute])) {
            return '';
        }
        if (!($this->optionProviders[$attribute] instanceof AbstractSource)) {
            return '';
        }
        return $this->optionProviders[$attribute]->getOptionText($this->getData($attribute));
    }
}
