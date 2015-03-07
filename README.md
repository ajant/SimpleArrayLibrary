SimpleArrayLibrary
==================
[![Build Status](https://travis-ci.org/ajant/SimpleArrayLibrary.svg?branch=master)](https://travis-ci.org/ajant/SimpleArrayLibrary)

Library containing convenient array handling methods.

Requirements
============

You'll need: PHP version 4.0.0+

Quickstart
==========
Install the latest version with composer:
```require "ajant/simple-array-library"```
Auto-load the library:
```use SimpleArrayLibrary/SimpleArrayLibrary```
and you're ready to go.

Here are some examples of usage:
```
SimpleArrayLibrary::allElementsEqual(array(1, 1)); // true
SimpleArrayLibrary::allElementsEqual(array(1, 2)); // false
SimpleArrayLibrary::allElementsEqual(array(1, 1), 1); // true
SimpleArrayLibrary::allElementsEqual(array(1, 1) 2); // false
```