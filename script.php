<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of HelloWorld component
 */
class com_diaryInstallerScript
{
        /**
         * method to install the component
         *
         * @return void
         */
        function install($parent) 
        {
                // $parent is the class calling this method
                // $parent->getParent()->setRedirectURL('index.php?option=com_helloworld');
        }
 
        /**
         * method to uninstall the component
         *
         * @return void
         */
        function uninstall($parent) 
        {
                // $parent is the class calling this method
                // echo '<p>' . JText::_('COM_HELLOWORLD_UNINSTALL_TEXT') . '</p>';
                // echo '<p>Uninstall successful</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
                // $parent is the class calling this method
                // echo '<p>' . JText::sprintf('COM_HELLOWORLD_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
                // echo '<p>Update successful</p>';
        }
 
        /**
         * method to run before an install/update/uninstall method
         *
         * @return void
         */
        function preflight($type, $parent) 
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                // echo '<p>' . JText::_('COM_HELLOWORLD_PREFLIGHT_' . $type . '_TEXT') . '</p>';
                // echo '<p>Preflight successful</p>';
        }
 
        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent) 
        {
                // $parent is the class calling this method
                // $type is the type of change (install, update or discover_install)
                // echo '<p>' . JText::_('COM_HELLOWORLD_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
                // $imagepath = JURI::root().'images/diarysocial';

                $imagepath = JPATH_SITE . '/images/diarysocial';
                if (!file_exists($imagepath)) {
                    mkdir($imagepath, 0755, true);
                    echo 'Directory: ' . $imagepath . ' created <br/><br/>';
                }
                $imagepath = JPATH_SITE . '/images/diaryitems';
                if (!file_exists($imagepath)) {
                    mkdir($imagepath, 0755, true);
                    echo 'Directory: ' . $imagepath . ' created <br/><br/>';
                }
                $filesource = JPATH_SITE.'/administrator/components/com_diary/assets/images/facebook.png';
                $filedestination = JPATH_SITE.'/images/diarysocial/facebook.png';
                copy($filesource, $filedestination);
                $filesource = JPATH_SITE.'/administrator/components/com_diary/assets/images/bird_blue_16.png';
                $filedestination = JPATH_SITE.'/images/diarysocial/bird_blue_16.png';
                copy($filesource, $filedestination);
                echo '<p>Images copied.</p>';
        }
}