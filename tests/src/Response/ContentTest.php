<?php
namespace Aura\Web\Response;

class ContentTest extends \PHPUnit_Framework_TestCase
{
    protected $content;
    protected $headers;
    
    protected function setUp()
    {
        $this->headers = new Headers;
        $this->content = new Content($this->headers);
    }
    
    public function testContent()
    {
        $content = 'foo bar baz';
        $this->content->set($content);
        $this->assertSame($content, $this->content->get());
    }

    public function testTypeAndCharset()
    {
        $expect = 'application/json';
        $this->content->setType($expect);
        $actual = $this->headers->get('Content-Type');
        $this->assertSame($expect, $actual);
        
        $this->content->setCharset('utf-8');
        $expect = 'application/json; charset=utf-8';
        $actual = $this->headers->get('Content-Type');
        $this->assertSame($expect, $actual);
        
        $actual = $this->content->getType();
        $expect = 'application/json';
        $this->assertSame($expect, $actual);
        
        $actual = $this->content->getCharset();
        $expect = 'utf-8';
        $this->assertSame($expect, $actual);
        
        $this->content->setType(null);
        $this->assertNull($this->headers->get('Content-Type'));
    }

    public function testDisposition()
    {
        $disposition = 'attachment';
        $this->content->setDisposition($disposition);
        $expect = 'attachment';
        $actual = $this->headers->get('Content-Disposition');
        
        $filename = 'example.txt';
        $this->content->setDisposition($disposition, $filename);
        $expect = 'attachment; filename="example.txt"';
        $actual = $this->headers->get('Content-Disposition');
        $this->assertSame($expect, $actual);
    }
    
    public function testEncoding()
    {
        $this->content->setEncoding('gzip');
        $expect = 'gzip';
        $actual = $this->headers->get('Content-Encoding');
        $this->assertSame($expect, $actual);
    }
}
