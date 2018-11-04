# TYPO3 Extension ``routes``

## 1. Features

- Provides an opportunity to call any extbase actions by url
- Route definition based on YAML
- Contains View Helper for building routes by name
- All routes could be strongly cached

## 2. Usage

### 1) Installation

#### Installation using Composer

The recommended way to install the extension is by using [Composer][2]. In your Composer based TYPO3 project root, just do `composer require lms/routes`. 

#### Installation as extension from TYPO3 Extension Repository (TER)

Will be possible in the future.

### 2) Minimal setup

1) Include the static TypoScript of the extension.
2) Create routes file under your extension **ext/my_extension/Configuration/Routes.yml**
3) Define your route in the **Routes.yml**


[1]: https://docs.typo3.org/typo3cms/extensions/routes/
[2]: https://getcomposer.org/
