# VodaPay Magento Plugin

## Installation

#### Install using Composer (recommended)

- From the Magento root directory, install the VodaPay module
  using ```composer require vodapay/vodapay```.

#### Install using FTP/SFTP

- Download ***magento-plugin-main.zip*** and unzip it to a directory on your local machine.
- Use an FTP tool (such as *FileZilla*) to upload the contents of ```magento-plugin-main``` directory to
  the ```app\code\VodaPay\VodaPay\```directory of your Magento installation.
- From the Magento root directory, install VodaPay dependencies
  using ```composer require ngenius/ngenius-common:v1.1.0```.

### Magento Build Steps

- ```bin/magento module:enable VodaPay_VodaPay```
- ```bin/magento setup:upgrade```
- ```bin/magento setup:di:compile```
- ```bin/magento indexer:reindex```
- ```bin/magento cache:clean```


## Download

You can download the latest version of the plugin from
our [Github releases page](https://github.com/VodaPay-Gateway/magento-plugin/releases)
