<?php
use PHPUnit\Framework\TestCase;

require 'converter.php';

class ConverterTest extends TestCase
{
    public function testH1Conversion()
    {
        $markdown = "# Heading 1";
        $expectedHtml = "<h1>Heading 1</h1>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testH2Conversion()
    {
        $markdown = "## Heading 2";
        $expectedHtml = "<h2>Heading 2</h2>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testH6Conversion()
    {
        $markdown = "###### Heading 6";
        $expectedHtml = "<h6>Heading 6</h6>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testEllipsis()
    {
        $markdown = "...";
        $expectedHtml = "...";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testUnformattedText()
    {
        $markdown = "Unformatted text";
        $expectedHtml = "<p>Unformatted text</p>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testLinkConversion()
    {
        $markdown = "[Link text](https://www.example.com)";
        $expectedHtml = "<p><a href=\"https://www.example.com\">Link text</a></p>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testMixed1()
    {
        $markdown = "This is a paragraph [with an inline link](http://google.com). Neat, eh?";
        $expectedHtml = "<p>This is a paragraph <a href=\"http://google.com\">with an inline link</a>. Neat, eh?</p>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }

    public function testMixed2()
    {
        $markdown = "## This is a header [with a link](http://yahoo.com)";
        $expectedHtml = "<h2>This is a header <a href=\"http://yahoo.com\">with a link</a></h2>";

        $this->assertEquals($expectedHtml, rtrim(convertMarkdownToHTML($markdown), "\n"));
    }
}
?>