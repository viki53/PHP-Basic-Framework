PHP Basic Framework
===================

Sometimes a real framework isn't necessary, when you just want to handle a fiew pages with a simple database.

Getting started
-------------

First, you need to set the ENVIRONMENT constant, so that the right config file is loaded and the errors are properly handled.

Then, you can edit the config file, depending on the environment : **development** or **production**. The file is named config-<small>*ENVIRONMENT*</small>.json. For example, if you're developping a brand new app, you should edit the **config-development.json** file.

If you don't know how to use the config file, you can look at the example file, **config_example.json**. This file is not a valid JSON file, as it contains several comments to help you understand and remember what every item is used for.