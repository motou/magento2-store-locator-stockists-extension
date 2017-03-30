<?php
declare(strict_types=1);
/**
 * Storelocator_Stockists extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Storelocator
 * @package   Storelocator_Stockists
 * @copyright 2016 Claudiu Creanga
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 * @author    Claudiu Creanga
 */
namespace Storelocator\Stockists\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\Collection\Db;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Storelocator\Stockists\Api\Data\StockistInterface;
use Storelocator\Stockists\Model\Stores\Url;
use Storelocator\Stockists\Model\ResourceModel\Stores as StockistResourceModel;
use Storelocator\Stockists\Model\Routing\RoutableInterface;
use Storelocator\Stockists\Model\Source\AbstractSource;

/**
 * @method StockistResourceModel _getResource()
 * @method StockistResourceModel getResource()
 */
class Stores extends AbstractModel implements StockistInterface, RoutableInterface
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
    public $urlModel;
    /**
     * cache tag
     *
     * @var string
     */
    const CACHE_TAG = 'storelocator_stockists';

    /**
     * cache tag
     *
     * @var string
     */
    public $_cacheTag = 'storelocator_stockists_stores';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $_eventPrefix = 'storelocator_stockists_stores';

    /**
     * filter model
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    public $filter;

    /**
     * @var UploaderPool
     */
    public $uploaderPool;

    /**
     * @var \Storelocator\Stockists\Model\Output
     */
    public $outputProcessor;

    /**
     * @var AbstractSource[]
     */
    public $optionProviders;

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
    ) {
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
    public function _construct()
    {
        $this->_init(StockistResourceModel::class);
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->getData(StockistInterface::TYPE);
    }

    /**
     * @param $storeId
     * @return StockistInterface
     */
    public function setStoreId($storeId)
    {
        $this->setData(StockistInterface::STORE_ID, $storeId);
        return $this;
    }
    
    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(StockistInterface::COUNTRY);
    }

    /**
     * set name
     *
     * @param $name
     * @return StockistInterface
     */
    public function setName($name)
    {
        return $this->setData(StockistInterface::NAME, $name);
    }

    /**
     * set type
     *
     * @param $type
     * @return StockistInterface
     */
    public function setType($type)
    {
        return $this->setData(StockistInterface::TYPE, $type);
    }

    /**
     * Set country
     *
     * @param $country
     * @return StockistInterface
     */
    public function setCountry($country)
    {
        return $this->setData(StockistInterface::COUNTRY, $country);
    }
    
        /**
     * set link
     *
     * @param $link
     * @return StockistInterface
     */
    public function setLink($link)
    {
        return $this->setData(StockistInterface::LINK, $link);
    }

    /**
     * set address
     *
     * @param $address
     * @return StockistInterface
     */
    public function setAddress($address)
    {
        return $this->setData(StockistInterface::ADDRESS, $address);
    }

    /**
     * set city
     *
     * @param $city
     * @return StockistInterface
     */
    public function setCity($city)
    {
        return $this->setData(StockistInterface::CITY, $city);
    }

    /**
     * set postcode
     *
     * @param $postcode
     * @return StockistInterface
     */
    public function setPostcode($postcode)
    {
        return $this->setData(StockistInterface::POSTCODE, $postcode);
    }

    /**
     * set region
     *
     * @param $region
     * @return StockistInterface
     */
    public function setRegion($region)
    {
        return $this->setData(StockistInterface::REGION, $region);
    }

    /**
     * set email
     *
     * @param $email
     * @return StockistInterface
     */
    public function setEmail($email)
    {
        return $this->setData(StockistInterface::EMAIL, $email);
    }

    /**
     * set phone
     *
     * @param $phone
     * @return StockistInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(StockistInterface::PHONE, $phone);
    }

    /**
     * set latitude
     *
     * @param $latitude
     * @return StockistInterface
     */
    public function setLatitude($latitude)
    {
        return $this->setData(StockistInterface::LATITUDE, $latitude);
    }
    
    /**
     * set longitude
     *
     * @param $longitude
     * @return StockistInterface
     */
    public function setLongitude($longitude)
    {
        return $this->setData(StockistInterface::LONGITUDE, $longitude);
    }

    /**
     * Set status
     *
     * @param $status
     * @return StockistInterface
     */
    public function setStatus($status)
    {
        return $this->setData(StockistInterface::STATUS, $status);
    }    
    
    /**
     * set image
     *
     * @param $image
     * @return StockistInterface
     */
    public function setImage($image)
    {
        return $this->setData(StockistInterface::IMAGE, $image);
    }

    /**
     * set created at
     *
     * @param $createdAt
     * @return StockistInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(StockistInterface::CREATED_AT, $createdAt);
    }

    /**
     * set updated at
     *
     * @param $updatedAt
     * @return StockistInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(StockistInterface::UPDATED_AT, $updatedAt);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(StockistInterface::NAME);
    }

    /**
     * Get url key
     *
     * @return string
     */
    public function getLink()
    {
        return $this->getData(StockistInterface::LINK);
    }
    
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getData(StockistInterface::ADDRESS);
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->getData(StockistInterface::CITY);
    }
    
    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->getData(StockistInterface::POSTCODE);
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->getData(StockistInterface::REGION);
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(StockistInterface::EMAIL);
    }
    
    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(StockistInterface::IMAGE);
    }
    
    /**
     * @return bool|string
     * @throws LocalizedException
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            if (is_string($image)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$image;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(StockistInterface::PHONE);
    }
    
    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->getData(StockistInterface::LATITUDE);
    }
    
    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->getData(StockistInterface::LONGITUDE);
    }

    /**
     * Get status
     *
     * @return bool|int
     */
    public function getStatus()
    {
        return $this->getData(StockistInterface::STATUS);
    }


    /**
     * Get created at
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(StockistInterface::CREATED_AT);
    }

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(StockistInterface::UPDATED_AT);
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
     * @return array
     */
    public function getStoreId()
    {
        return $this->getData(StockistInterface::STORE_ID);
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
    public function getStockistUrl()
    {
        return $this->urlModel->getStockistUrl($this);
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
