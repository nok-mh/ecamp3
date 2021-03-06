<?php

namespace eCamp\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use eCamp\Core\ContentType\ContentTypeStrategyInterface;
use eCamp\Core\ContentType\ContentTypeStrategyProviderAware;
use eCamp\Core\ContentType\ContentTypeStrategyProviderTrait;
use eCamp\Lib\Entity\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ActivityContent extends BaseEntity implements ContentTypeStrategyProviderAware, BelongsToCampInterface {
    use ContentTypeStrategyProviderTrait;

    /**
     * @var Activity
     * @ORM\ManyToOne(targetEntity="Activity")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    public $activity;

    /**
     * @var ContentType
     * @ORM\ManyToOne(targetEntity="ContentType")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $contentType;

    /**
     * @var string
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $instanceName;

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return Activity
     */
    public function getActivity() {
        return $this->activity;
    }

    public function setActivity($activity) {
        $this->activity = $activity;
    }

    public function getCamp() {
        return (null != $this->activity) ? $this->activity->getCamp() : null;
    }

    /**
     * @return ContentType
     */
    public function getContentType() {
        return $this->contentType;
    }

    public function setContentType(ContentType $contentType): void {
        $this->contentType = $contentType;
    }

    /**
     * @return ActivityTypeContentType
     */
    /*
    public function getActivityTypeContentType() {
        return (null != $this->contentType) ? $this->activityTypeContentType->getContentType() : null;
    }*/

    /**
     * @return string
     */
    public function getInstanceName() {
        return $this->instanceName;
    }

    public function setInstanceName($instanceName): void {
        $this->instanceName = $instanceName;
    }

    /**
     * Returns the strategy class of the content-type.
     *
     * @return ContentTypeStrategyInterface
     */
    public function getContentTypeStrategy() {
        return $this->getContentTypeStrategyProvider()->get($this->getContentType());
    }

    /** @ORM\PrePersist */
    public function PrePersist() {
        $this->getContentTypeStrategy()->activityContentCreated($this);
    }
}
