<?php
/**
* @version        $Id: mobile.php 20196 2011-01-09 02:40:25Z ian $
* @package        Joomla.Framework
* @subpackage     Form
*/

defined('JPATH_BASE') or die;

jimport('joomla.form.formrule');

/**
* Form Rule class for the Joomla Framework.
*
* @package        Joomla.Framework
* @since          1.6
*/
class JFormRulephoto extends JFormRule
{
    /**
    * Method to test the username for uniqueness.
    *
    * @param    object    $element    The JXMLElement object representing the <field /> tag for the
    *                                 form field object.
    * @param    mixed     $value      The form field value to validate.
    * @param    string    $group      The field name group control value. This acts as as an array
    *                                 container for the field. For example if the field has name="foo"
    *                                 and the group value is set to "bar" then the full field name
    *                                 would end up being "bar[foo]".
    * @param    object    $input      An optional JRegistry object with the entire data set to validate
    *                                 against the entire form.
    * @param    object    $form       The form object for which the field is being tested.
    *
    * @return   boolean               True if the value is valid, false otherwise.
    * @since    1.6
    * @throws   JException on invalid rule.
    */
    public function test($element, $value, $group = null, & $input = null, & $form = null)
    {

        
   }
}