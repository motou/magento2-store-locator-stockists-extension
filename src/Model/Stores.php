<?php
declare(strict_types=1);
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

use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\Collection\Db;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\FilterManager;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Limesharp\Stockists\Api\Data\StockistInterface;
use Limesharp\Stockists\Model\Stores\Url;
use Limesharp\Stockists\Model\ResourceModel\Stores as StockistResourceModel;
use Limesharp\Stockists\Model\Routing\RoutableInterface;
use Limesharp\Stockists\Model\Source\AbstractSource;

/**
 * @method StockistResourceModel _getResource()
 * @method StockistResourceModel getResource()
 */
class Stores extends AbstractExtensibleModel implements StockistInterface, RoutableInterface
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
    const CACHE_TAG = 'limesharp_stockists';

    /**
     * cache tag
     *
     * @var string
     */
    public $_cacheTag = 'limesharp_stockists_stores';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    public $_eventPrefix = 'limesharp_stockists_stores';

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
     * @var AbstractSource[]
     */
    public $optionProviders;

    /**
     * @var \Limesharp\Stockists\Api\Data\Stockist\CustomAttributeListInterface
     */
    private $attributeList;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
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
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        UploaderPool $uploaderPool,
        FilterManager $filter,
        Url $urlModel,
        array $optionProviders = [],
        array $data = [],
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null
    ) {
        $this->uploaderPool    = $uploaderPool;
        $this->filter          = $filter;
        $this->urlModel        = $urlModel;
        $this->optionProviders = $optionProviders;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
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
     * set external link
     *
     * @param $external_link
     * @return StockistInterface
     */
    public function setExternalLink($external_link)
    {
        return $this->setData(StockistInterface::EXTERNAL_LINK, $external_link);
    }


    /**
     * set schedule
     *
     * @param $schedule
     * @return StockistInterface
     */
    public function setSchedule($schedule)
    {
        return $this->setData(StockistInterface::SCHEDULE, $schedule);
    }

    /**
     * set distance
     *
     * @param $distance
     * @return StockistInterface
     */
    public function setDistance($distance)
    {
        return $this->setData(StockistInterface::DISTANCE, $distance);
    }

    /**
     * set description
     *
     * @param $description
     * @return StockistInterface
     */
    public function setDescription($description)
    {
        return $this->setData(StockistInterface::DESCRIPTION, $description);
    }

    /**
     * set station
     *
     * @param $station
     * @return StockistInterface
     */
    public function setStation($station)
    {
        return $this->setData(StockistInterface::STATION, $station);
    }

    /**
     * set intro
     *
     * @param $intro
     * @return StockistInterface
     */
    public function setIntro($intro)
    {
        return $this->setData(StockistInterface::INTRO, $intro);
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
     * Get schedule
     *
     * @return string
     */
    public function getSchedule()
    {
        return $this->getData(StockistInterface::SCHEDULE);
    }

    /**
     * Get intro
     *
     * @return string
     */
    public function getIntro()
    {
        return $this->getData(StockistInterface::INTRO);
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(StockistInterface::DESCRIPTION);
    }

    /**
     * Get station
     *
     * @return string
     */
    public function getStation()
    {
        return $this->getData(StockistInterface::STATION);
    }

    /**
     * Get distance
     *
     * @return string
     */
    public function getDistance()
    {
        return $this->getData(StockistInterface::DISTANCE);
    }

    /**
     * Get details image
     *
     * @return string
     */
    public function getDetailsImage()
    {
        return $this->getData(StockistInterface::DETAILS_IMAGE);
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
     * @return bool|string
     * @throws LocalizedException
     */
    public function getDetailsImageUrl()
    {
        $url = false;
        $image = $this->getDetailsImage();
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
     * Get external link
     *
     * @return string
     */
    public function getExternalLink()
    {
        return $this->getData(StockistInterface::EXTERNAL_LINK);
    }

    /**
     * set details image
     *
     * @param $details_image
     * @return StockistInterface
     */
    public function setDetailsImage($details_image)
    {
        return $this->setData(StockistInterface::DETAILS_IMAGE, $details_image);
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
        return [self::CACHE_TAG . '_' . $this->getStoreId()];
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

    /**
     * {@inheritdoc}
     *
     * @return \Magento\Catalog\Api\Data\CategoryProductLinkExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Magento\Catalog\Api\Data\CategoryProductLinkExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\Catalog\Api\Data\CategoryProductLinkExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCustomAttributesCodes()
    {
        return array_keys($this->getAttributeList()->getAttributes());
    }

    /**
     * Get new AttributeList dependency for application code.
     * @return \Magento\Customer\Model\Address\CustomAttributeListInterface
     */
    private function getAttributeList()
    {
        if (!$this->attributeList) {
            $this->attributeList = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Limesharp\Stockists\Api\Data\Stockist\CustomAttributeListInterface::class
            );
        }
        return $this->attributeList;
    }
}
