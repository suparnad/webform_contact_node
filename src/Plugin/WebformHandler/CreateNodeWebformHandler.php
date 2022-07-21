<?php

namespace Drupal\webform_contact_node\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\node\Entity\Node;


/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "article_from_webform",
 *   label = @Translation("Create a new node"),
 *   category = @Translation("Entity Creation"),
 *   description = @Translation("Creates a new node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_IGNORED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */

class CreateNodeWebformHandler extends WebformHandlerBase
{
  /**
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission)
  {

    // Get an array of form field values.
    $submission_array = $webform_submission->getData();

    // Dump the $submission_array to acquire the fields if you don't know what fields you're working with. 

    // Prepare variables for use in the node.  
    $title = $submission_array['subject'];
    $body = "<p>" . $submission_array['name'] . "<br/>";
    $body .= $submission_array['message'];
    $email = $submission_array['email'];

    // Create the node.
    $node = Node::create([
      'type' => 'webform_contact_node',
      'status' => FALSE,
      'title' => $title,

      'body' => [
        'value' => $body,
        'format' => 'basic_html',
      ],
      'field_email' => $email,

    ]);

    // Save the node. 
    $node->save();
  }
}
