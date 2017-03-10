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

use Magento\Config\Model\Config\Backend\Image as SourceImage;
 
class SystemImage extends SourceImage
{
	
    /**
     * The tail part of directory path for uploading
     * @var string
     */    
    const UPLOAD_DIR = 'storelocator_stockists';
 
    /**
     * Upload max file size in kilobytes
     *
     * @var int
     */
    protected $_maxFileSize = 2048;
     
    /**
     * Uploader object
     *
     * @var Uploader
     */
    private $uploader;
    
 
    /**
     * Return path to directory for upload file
     *
     * @return string
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }
 
    /**
     * Makes a decision about whether to add info about the scope
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }
 
    /**
     * Save uploaded file before saving config value
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $file = $this->getFileData();
        if (!empty($file)) {
            $uploadDir = $this->_getUploadDir();
            try {
                /** @var Uploader $uploader */
                $uploader = $this->_uploaderFactory->create(['fileId' => $file]);
                $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                $uploader->setAllowRenameFiles(true);
                $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                $result = $uploader->save($uploadDir);
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(__('%1', $e->getMessage()));
            }

            $filename = $result['file'];
            if ($filename) {
                if ($this->_addWhetherScopeInfo()) {
                    $filename = $this->_prependScopeInfo($filename);
                }
                $this->setValue($filename);
            }
        } else {
            if (is_array($value) && !empty($value['delete'])) {
                $this->setValue('');
            } else {
                $this->unsValue();
            }
        }

        return $this;
    }
}
