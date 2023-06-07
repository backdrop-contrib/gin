# Tonic Admin Theme

## Contents of this file

 - Introduction
 - Requirements
 - Installation
 - Configuration
 - Troubleshooting
 - Maintainers
## Introduction

A radically new UI layout paired with goodies like a Darkmode will give your Drupal's Admin interface a facelift. The Tonic theme also includes things which are currently out of scope for Claro and/or some customisations we're experimenting with for the future. Built on the foundation of Claro from one of the lead designers of Claro & Drupal Design System.

Tonic can be used in a headless environment, as it provides a nice [login screen](https://drupal.org/project/tonic_login) which is missing in the default Drupal admin themes.

- For a full description of the module, visit the [project page](https://www.drupal.org/project/tonic).
- Use the [Issue queue](https://www.drupal.org/project/issues/tonic) to submit bug reports and feature suggestions, or track changes.
- Documentation can be found [here](https://www.drupal.org/docs/contributed-themes/tonic-admin-theme).
## Requirements

This theme requires Drupal core >= 9.0.

**Note**: For all functions to work properly, it is recommended that you also install [Tonic Toolbar](https://drupal.org/project/tonic_toolbar).

## Installation

Install as you would normally install a contributed Drupal theme. See [Tonic documentation](https://www.drupal.org/drupalorg/docs/content/tonic-admin-theme/installation-and-configuration) or visit https://www.drupal.org/node/1897420 for further information.

### Set Tonic as default admin theme

 - Navigate to Admin > Appearance
 - On the same page, click "Install" under Tonic
 - At the bottom of the page, switch the Administration theme to Tonic

## Troubleshooting

- Setup Tonic locally that you can compile CSS & JS files.\
`nvm use && npm i`

- Run dev env with watcher and debug output (development process)\
`npm run dev`

- Compile assets\
`npm run build`

## Maintainers

Current maintainers:
- Sascha Eggenberger ([@saschaeggi](https://www.drupal.org/u/saschaeggi))
