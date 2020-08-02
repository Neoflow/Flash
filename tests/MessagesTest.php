<?php

namespace Neoflow\FlashMessages\Test;

use Neoflow\FlashMessages\Messages;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    /**
     * @var Messages
     */
    protected $messages;

    protected function setUp(): void
    {
        $this->messages = Messages::create([
            'm1' => [
                '1 Message A',
            ],
            'm2' => []
        ]);
    }

    public function testAdd(): void
    {
        $this->messages->add('m1', '1 Message B');
        $this->messages->add('m2', '2 Message A');
        $this->messages->add('m3', '3 Message A');

        $this->assertSame([
            'm1' => [
                '1 Message A',
                '1 Message B',
            ],
            'm2' => [
                '2 Message A',
            ],
            'm3' => [
                '3 Message A',
            ]
        ], $this->messages->toArray());
    }

    public function testClear(): void
    {
        $this->messages->clear('m1');

        $this->assertSame([], $this->messages->get('m1'));
    }

    public function testClearAll(): void
    {
        $this->messages->clearAll();

        $this->assertSame([], $this->messages->toArray());
    }

    public function testCount(): void
    {
        $this->assertSame(1, $this->messages->count('m1'));
        $this->assertSame(0, $this->messages->count('m9'));
    }

    public function testCountKeys(): void
    {
        $this->assertSame(2, $this->messages->countKeys());
    }

    public function testCreateByReference(): void
    {
        $GLOBALS = [
            'm1' => [
                '1 Message A'
            ]
        ];

        $message = Messages::createByReference($GLOBALS);

        $message->add('m1', '2 Message B');

        $this->assertSame($GLOBALS, $message->toArray());
    }

    public function testDelete(): void
    {
        $this->messages->delete('m1');

        $this->assertFalse($this->messages->hasKey('m1'));
    }

    public function testGet(): void
    {
        $this->assertSame([
            '1 Message A'
        ], $this->messages->get('m1'));

        $this->assertSame([], $this->messages->get('m9'));
    }

    public function testGetFirst(): void
    {
        $this->messages->add('m1', '1 Message B');

        $this->assertSame('1 Message A', $this->messages->getFirst('m1'));
        $this->assertSame([], $this->messages->getFirst('m9'));
    }

    public function testGetLast(): void
    {
        $this->messages->add('m1', '1 Message B');

        $this->assertSame('1 Message B', $this->messages->getLast('m1'));
        $this->assertSame([], $this->messages->getLast('m9'));
    }

    public function testHasKey(): void
    {
        $this->assertTrue($this->messages->hasKey('m1'));
        $this->assertFalse($this->messages->hasKey('m9'));
    }

    public function testToArray(): void
    {
        $this->assertSame([
            'm1' => [
                '1 Message A',
            ],
            'm2' => []
        ], $this->messages->toArray());
    }
}