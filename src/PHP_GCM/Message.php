<?php

namespace PHP_GCM;

class Message {

  const COLLAPSE_KEY = 'collapse_key';
  const TIME_TO_LIVE = 'time_to_live';
  const DRY_RUN = 'dry_run';
  const DELAY_WHILE_IDLE = 'delay_while_idle';
  const RESTRICTED_PACKAGE_NAME = 'restricted_package_name';
  const REGISTRATION_IDS = 'registration_ids';
  const DATA = 'data';
  const NOTIFICATION = 'notification';
  const TO = 'to';

  private $collapseKey;
  private $delayWhileIdle;
  private $dryRun;
  private $timeToLive;
  private $notification;
  private $data;
  private $restrictedPackageName;
  private $contentAvailable;
  private $priority;

  /**
   * Message Constructor
   *
   * @param array $notification
   * @param array $options
   */
  public function __construct(array $notification = array(), array $options = array()) {
      $defaultOptions = array(
        'collapseKey' => '',
        'timeToLive' => 2419200,
        '$delayWhileIdle' => false,
        'restrictedPackageName' => '',
        'dryRun' => false,
        'contentAvailable' => true,
        'priority' => 'high',
      );
      
      $options = array_merge($defaultOptions, $options);
      
      foreach ( $options as $k=>$opt ) {
        $this->{$k} = $opt;
      }
      
      $this->notification = $notification;
    }

  /**
   * Sets the collapseKey property.
   *
   * @param string $collapseKey
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function collapseKey($collapseKey) {
    $this->collapseKey = $collapseKey;
    return $this;
  }

  /**
   * Gets the collapseKey property
   *
   * @return string
   */
  public function getCollapseKey() {
    return $this->collapseKey;
  }

  /**
   * Sets the delayWhileIdle property (default value is {false}).
   *
   * @param bool $delayWhileIdle
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function delayWhileIdle($delayWhileIdle) {
    $this->delayWhileIdle = $delayWhileIdle;
    return $this;
  }

  /**
   * Gets the delayWhileIdle property
   *
   * @return bool
   */
  public function getDelayWhileIdle() {
    if(isset($this->delayWhileIdle))
      return $this->delayWhileIdle;
    return null;
  }

  /**
   * Sets the dryRun property (default value is {false}).
   *
   * @param bool $dryRun
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function dryRun($dryRun) {
    $this->dryRun = $dryRun;
    return $this;
  }

  /**
   * Gets the dryRun property
   *
   * @return bool
   */
  public function getDryRun() {
    return $this->dryRun;
  }

  /**
   * Sets the time to live, in seconds.
   *
   * @param int $timeToLive
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function timeToLive($timeToLive) {
    $this->timeToLive = $timeToLive;
    return $this;
  }

  /**
   * Gets the timeToLive property
   *
   * @return int
   */
  public function getTimeToLive() {
    return $this->timeToLive;
  }

  /**
   * Adds a key/value pair to the payload data.
   *
   * @param string $key
   * @param string $value
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function addData($key, $value) {
    $this->data[$key] = $value;
    return $this;
  }

  /**
   * Sets the data property
   *
   * @param array $data
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function data(array $data) {
    $this->data = $data;
    return $this;
  }

  /**
   * Gets the data property
   *
   * @return array
   */
  public function getData() {
    return $this->data;
  }

  /**
   * Sets the restrictedPackageName property.
   *
   * @param string $restrictedPackageName
   * @return Message Returns the instance of this Message for method chaining.
   */
  public function restrictedPackageName($restrictedPackageName) {
    $this->restrictedPackageName = $restrictedPackageName;
    return $this;
  }

  /**
   * Gets the restrictedPackageName property
   *
   * @return string
   */
  public function getRestrictedPackageName() {
    return $this->restrictedPackageName;
  }

  public function build($recipients) {
    $message = array();

    if (!is_array($recipients)) {
      $message[self::TO] = $recipients;
    } else if (count($recipients) == 1) {
      $message[self::TO] = $recipients[0];
    } else {
      $message[self::REGISTRATION_IDS] = $recipients;
    }

    if ($this->collapseKey != '') {
      $message[self::COLLAPSE_KEY] = $this->collapseKey;
    }

    $message[self::DELAY_WHILE_IDLE] = $this->delayWhileIdle;
    $message[self::TIME_TO_LIVE] = $this->timeToLive;
    $message[self::DRY_RUN] = $this->dryRun;

    if ($this->restrictedPackageName != '') {
      $message[self::RESTRICTED_PACKAGE_NAME] = $this->restrictedPackageName;
    }

    if (!is_null($this->data) && count($this->data) > 0) {
      $message[self::DATA] = $this->data;
    }

    if (!is_null($this->notification) && count($this->notification) > 0) {
      $message[self::NOTIFICATION] = $this->notification;
    }

    return json_encode($message);
  }
}
