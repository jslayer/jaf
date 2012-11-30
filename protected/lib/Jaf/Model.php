<?php
/**
 * Jaf_Model class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Model
 */

/**
 * Base model class
 *
 * @class Jaf_Db_SQLite
 */
class Jaf_Model {
  /**
   * TODO: Implement
   */

  /**
   * Array of model keys
   * @var array
   */
  protected $_keys = array();

  /**
   * Constructor
   * @param SimpleXMLElement|array $data
   */
  public function __construct($data) {
    $type = FALSE;

    if (is_array($data)) {
      $type = 'array';
    }
    elseif (is_object($data) && is_a($data, 'SimpleXMLElement')) {
      $type = 'xml';
    }

    if ($type) {
      foreach($this->_keys as $key) {
        switch($type) {
          case 'array':
            if (isset($data[$key])) {
              $this->{$key} = $data[$key];
            }
            break;
          case 'xml':
            if (isset($data->{$key})) {
              $count = $data->{$key}->count();
              if ($count < 2) {
                $this->{$key} = (string) $data->{$key};
              }
              else {
                $this->{$key} = array();
                for($i=0; $i<$count; $i++) {
                  $this->{$key}[$i] = (string) $data->{$key}->{$i};
                }
              }
            }
            break;
        }
      }
    }
  }

  /*public function save() {}

  public function delete() {}*/
}