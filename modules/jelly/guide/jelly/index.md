# Getting Started

This is the documentation for Jelly, an ORM for Kohana 3.1+.

[!!] __Please Note:__ this version of Jelly is a community fork, and it's goal is to ensure the compatibility with the latest Kohana version and fix bugs. It was created, because the [official module](http://github.com/jonathangeiger/kohana-jelly) was not updated recently.

First off, if you're already feeling lost feel free to ask a question in [the Kohana forums](http://forum.kohanaframework.org)—we're all very nice and helpful. If you feel better looking at the source, you can always [view the API documentation](../api/Jelly) or [browse the source on Github](https://github.com/creatoro/jelly).

## Installation

To install Jelly simply [download the latest release](https://github.com/creatoro/jelly) and place it in your modules directory. After that you must edit your `application/bootstrap.php` file and modify the call to `Kohana::modules` to include the Jelly module:

	Kohana::modules(array(
	    ...
	    'database' => MODPATH.'database',
		'jelly'    => MODPATH.'jelly',
	    ...
	));
	
Notice that Jelly depends on Kohana 3.x's [database module](http://github.com/kohana/database). Make sure you install and configure that as well.

If you are planning to use the __[Auth driver](https://github.com/creatoro/jelly-auth)__ you have to set the cookie salt by following [these instructions](../kohana/upgrading#cookie-salts).

## Requirements

Jelly requires the following Kohana versions per [Git](https://github.com/creatoro/jelly) branch:

 - __3.1/develop and 3.1/master branches:__ Kohana 3.1.3+
 - __3.2/develop and 3.2/master branches:__ Kohana 3.2+

## Basic Usage

The basic operations needed to work with Jelly are:

1.  [Defining models](getting-started/defining-models)
2.  [Loading and listing records](getting-started/loading-and-listing)
3.  [Creating, updating and deleting records](getting-started/cud)
4.  [Accessing and managing relationships](relationships)

## More Advanced Use

Jelly is incredibly flexible with almost all aspects of its behavior
being transparently extendable. The guides below give an overview of some more
advanced usage.

1.  [Extending the query builder](extending-builder)
2.  [Defining custom fields](field-types/custom)

## Get Involved in Jelly's developement

As Jelly has always been a community project it's development and future depends on people who are willing to put some time into it.
The easiest way to contribute is to fork the project on [GitHub](https://github.com/creatoro/jelly).

__Remember:__

* you can directly edit files on GitHub (look for the __Edit this file__ button), there's no need to get familiar with Git if you don't want to
* please follow the [Kohana conventions](../kohana/conventions) for coding
* read the [introduction to the unit tests](unit-tests) and run them if you make changes to Jelly to minimalize the chances of introducing new bugs
* and thanks for helping Jelly become better!