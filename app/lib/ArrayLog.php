<?php
/**
 * PHPUnit
 *
 * Copyright (c) 2001-2013, Sebastian Bergmann <sebastian@phpunit.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPUnit
 * @subpackage Util_Log
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2013 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      File available since Release 3.0.0
 */

/**
 * A TestListener that generates an Array of messages.
 *
 * @package    PHPUnit
 * @subpackage Util_Log
 * @author     Sebastian Bergmann <sebastian@phpunit.de>
 * @copyright  2001-2013 Sebastian Bergmann <sebastian@phpunit.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://www.phpunit.de/
 * @since      Class available since Release 3.0.0
 */
class ArrayLog extends \PHPUnit\Util\Printer implements \PHPUnit\Framework\TestListener
{
    /**
     * @var    array
     */
    protected $testOutput = array();

    /**
     * @var    string
     */
    protected $currentTestSuiteName = '';

    /**
     * @var    string
     */
    protected $currentTestName = '';

    /**
     * @var     boolean
     * @access  private
     */
    protected $currentTestPass = true;

    /**
     * An error occurred.
     *
     * @param  \PHPUnit\Framework\Test $test
     * @param  Exception              $e
     * @param  float                  $time
     */
    public function addError(\PHPUnit\Framework\Test $test, Throwable $t, float $time): void
    {
        $this->writeCase(
          'error',
          $time,
          \PHPUnit\Util\Filter::getFilteredStacktrace($t),
          $t->getMessage(),
          $test
        );

        $this->currentTestPass = false;
    }

    /**
     * A failure occurred.
     *
     * @param  \PHPUnit\Framework\Test                 $test
     * @param  \PHPUnit\Framework\AssertionFailedError $e
     * @param  float                                  $time
     */
    public function addFailure(\PHPUnit\Framework\Test $test, \PHPUnit\Framework\AssertionFailedError $e, float $time): void
    {
        $this->writeCase(
          'fail',
          $time,
          \PHPUnit\Util\Filter::getFilteredStacktrace($e),
          $e->getMessage(),
          $test
        );

        $this->currentTestPass = false;
    }

    /**
     * Incomplete test.
     *
     * @param  \PHPUnit\Framework\Test $test
     * @param  Exception               $throwable
     * @param  float                   $time
     */
    public function addIncompleteTest(\PHPUnit\Framework\Test $test, Throwable $t, float $time): void
    {
        $this->writeCase(
          'error',
          $time,
          \PHPUnit\Util\Filter::getFilteredStacktrace($t),
          'Incomplete Test: ' . $t->getMessage(),
          $test
        );

        $this->currentTestPass = false;
    }

    /**
     * Skipped test.
     *
     * @param  \PHPUnit\Framework\Test $test
     * @param  Exception              $t
     * @param  float                  $time
     */
    public function addSkippedTest(\PHPUnit\Framework\Test $test, Throwable $t, float $time): void
    {
        $this->writeCase(
          'error',
          $time,
          \PHPUnit\Util\Filter::getFilteredStacktrace($t),
          'Skipped Test: ' . $t->getMessage(),
          $test
        );

        $this->currentTestPass = false;
    }

    /**
     * Risky test.
     *
     * @param \PHPUnit\Framework\Test $test
     * @param Exception              $t
     * @param float                  $time
     * @since  Method available since Release 4.0.0
     */
    public function addRiskyTest(\PHPUnit\Framework\Test $test, Throwable $t, float $time): void
    {
        $this->writeCase(
          'error',
          $time,
          \PHPUnit\Util\Filter::getFilteredStacktrace($t),
          'Risky Test: ' . $t->getMessage(),
          $test
        );

        $this->currentTestPass = false;
    }

    /**
     * An warning is issued
     *
     * @param  \PHPUnit\Framework\Test $test
     * @param  Exception              $e
     * @param  float                  $time
     */
    public function addWarning(\PHPUnit\Framework\Test $test, \PHPUnit\Framework\Warning $e, float $time): void
    {
        $this->writeCase(
            'warning',
            $time,
            \PHPUnit\Util\Filter::getFilteredStacktrace($e),
            $e->getMessage(),
            $test
        );

        $this->currentTestPass = false;
    }

    /**
     * A testsuite started.
     *
     * @param  \PHPUnit\Framework\TestSuite $suite
     */
    public function startTestSuite(\PHPUnit\Framework\TestSuite $suite): void
    {
        $this->currentTestSuiteName = $suite->getName();
        $this->currentTestName      = '';

        $this->arrayWrite(
          array(
            'event' => 'suiteStart',
            'suite' => $this->currentTestSuiteName,
            'tests' => count($suite)
          )
        );
    }

    /**
     * A testsuite ended.
     *
     * @param  \PHPUnit\Framework\TestSuite $suite
     */
    public function endTestSuite(\PHPUnit\Framework\TestSuite $suite): void
    {
        $this->currentTestSuiteName = '';
        $this->currentTestName      = '';
    }

    /**
     * A test started.
     *
     * @param  \PHPUnit\Framework\Test $test
     */
    public function startTest(\PHPUnit\Framework\Test $test): void
    {
        $this->currentTestName = \PHPUnit\Util\Test::describe($test);
        $this->currentTestPass = true;

        $this->arrayWrite(
          array(
            'event' => 'testStart',
            'suite' => $this->currentTestSuiteName,
            'test'  => $this->currentTestName
          )
        );
    }

    /**
     * A test ended.
     *
     * @param  \PHPUnit\Framework\Test $test
     * @param  float                  $time
     */
    public function endTest(\PHPUnit\Framework\Test $test, float $time): void
    {
        if ($this->currentTestPass) {
            $this->writeCase('pass', $time, '', '', $test);
        }
    }

    /**
     * @param string $status
     * @param float  $time
     * @param array  $trace
     * @param string $message
     */
    protected function writeCase(string $status, float $time, $trace, string $message = '', $test = null)
    {
        $output = '';
        if ($test !== null && $test->hasOutput()) {
            $output = $test->getActualOutput();
        }
        $this->arrayWrite(
          array(
            'event'   => 'test',
            'suite'   => $this->currentTestSuiteName,
            'test'    => $this->currentTestName,
            'status'  => $status,
            'time'    => $time,
            'trace'   => $trace,
//            'message' => \PHPUnit\Util\Utf8::convertToUtf8($message),
            'message' => $message,
            'output'  => $output,
          )
        );
    }

    /**
     * @param string $buffer
     */
    public function arrayWrite(array $buffer): void
    {
        $this->testOutput[]=$buffer;
    }

    /**
     * @return array test results
     */
    public function getResults()
    {
        return $this->testOutput;
    }
}
