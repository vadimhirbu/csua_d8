<?php

/**
 * @file
 * Contains \Drupal\Core\Render\Element\Actions.
 */

namespace Drupal\Core\Render\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

/**
 * Provides a wrapper element to group one or more buttons in a form.
 *
 * Use of the 'actions' element as an array key helps to ensure proper styling
 * in themes and to enable other modules to properly alter a form's actions.
 *
 * @RenderElement("actions")
 */
class Actions extends Container {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return array(
      '#process' => array(
        // @todo Move this to #pre_render.
        array($class, 'preRenderActionsDropbutton'),
        array($class, 'processActions'),
        array($class, 'processContainer'),
      ),
      '#weight' => 100,
      '#theme_wrappers' => array('container'),
    );
  }

  /**
   * Processes a form actions container element.
   *
   * @param array $element
   *   An associative array containing the properties and children of the
   *   form actions container.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $complete_form
   *   The complete form structure.
   *
   * @return array
   *   The processed element.
   */
  public static function processActions(&$element, FormStateInterface $form_state, &$complete_form) {
    $element['#attributes']['class'][] = 'form-actions';
    return $element;
  }

  /**
   * #pre_render callback for #type 'actions'.
   *
   * This callback iterates over all child elements of the #type 'actions'
   * container to look for elements with a #dropbutton property, so as to group
   * those elements into dropbuttons. As such, it works similar to #group, but is
   * specialized for dropbuttons.
   *
   * The value of #dropbutton denotes the dropbutton to group the child element
   * into. For example, two different values of 'foo' and 'bar' on child elements
   * would generate two separate dropbuttons, which each contain the corresponding
   * buttons.
   *
   * @param array $element
   *   The #type 'actions' element to process.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $complete_form
   *   The complete form structure.
   *
   * @return array
   *   The processed #type 'actions' element, including individual buttons grouped
   *   into new #type 'dropbutton' elements.
   */
  public static function preRenderActionsDropbutton(&$element, FormStateInterface $form_state, &$complete_form) {
    $dropbuttons = array();
    foreach (Element::children($element, TRUE) as $key) {
      if (isset($element[$key]['#dropbutton'])) {
        $dropbutton = $element[$key]['#dropbutton'];
        // If there is no dropbutton for this button group yet, create one.
        if (!isset($dropbuttons[$dropbutton])) {
          $dropbuttons[$dropbutton] = array(
            '#type' => 'dropbutton',
          );
        }
        // Add this button to the corresponding dropbutton.
        // @todo Change #type 'dropbutton' to be based on theme_item_list()
        //   instead of links.html.twig to avoid this preemptive rendering.
        $button = drupal_render($element[$key]);
        $dropbuttons[$dropbutton]['#links'][$key] = array(
          'title' => $button,
          'html' => TRUE,
        );
      }
    }
    // @todo For now, all dropbuttons appear first. Consider to invent a more
    //   fancy sorting/injection algorithm here.
    return $dropbuttons + $element;
  }

}
