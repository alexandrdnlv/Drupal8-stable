<?php

namespace Drupal\author_name\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'AuthorNameBlock' block.
 *
 * @Block(
 *  id = "author_name_block",
 *  admin_label = @Translation("Author name"),
 * )
 */
class AuthorNameBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'custom_text_to_display' => $this->t(''),
      'display_custom_text_if_checked' => 1,
    ] + parent::defaultConfiguration();

  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['custom_text_to_display'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Custom text to display'),
      '#description' => $this->t('Please enter custom text to be displayed on block'),
      '#default_value' => $this->configuration['custom_text_to_display'],
      '#weight' => '0',
    ];
    $form['display_custom_text_if_checked'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display custom text if checked'),
      '#description' => $this->t('If checked, custom text will be displayed, otherwise -- author`s name'),
      '#default_value' => $this->configuration['display_custom_text_if_checked'],
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['custom_text_to_display'] = $form_state->getValue('custom_text_to_display');
    $this->configuration['display_custom_text_if_checked'] = $form_state->getValue('display_custom_text_if_checked');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if ($this->configuration['display_custom_text_if_checked']) {
      $build['author_name_block_custom_text_to_display']['#markup'] = '<p>' . $this->configuration['custom_text_to_display'] . '</p>';
    }
    else {
      /** @var \User $user */
      $user = \Drupal::currentUser();
      $username = $user->getUsername();
      $build['author_name_block_custom_text_to_display']['#markup'] = '<p>' . $username . '</p>';
    }
    return $build;
  }

}
