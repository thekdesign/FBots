<?php

namespace ThekDesign\FBots;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Commands\Command;
use BotMan\BotMan\Exceptions\Base\BotManException;
use BotMan\BotMan\Exceptions\Core\BadMethodCallException;
use BotMan\BotMan\Exceptions\Core\UnexpectedValueException;
use BotMan\BotMan\Interfaces\DriverInterface;
use BotMan\BotMan\Interfaces\UserInterface;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FBots
{

    //Create the bots
    private $bots;

    public function __construct(Request $request)
    {
        $this->bots = FBotsFactory::create($request);
    }

    /********************************************/
    /*                chat method               */
    /* ---------------------------------------- */
    /* $hears  : keyword that start to reply    */
    /* $reply  : write what you want to reply   */
    /* ---------------------------------------- */
    /********************************************/

    public function chat($hears, $reply)
    {

        $this->bots->hears($hears, function (BotMan $bot) use ($reply) {

            $bot->reply($reply);

        });
    }

    /********************************************/
    /*            chat_fallback method          */
    /* ---------------------------------------- */
    /* $reply  : write what you want to reply   */
    /* ---------------------------------------- */
    /********************************************/

    public function chat_fallback($reply)
    {

        $this->bots->fallback(function (BotMan $bot) use ($reply) {

            $bot->reply($reply);

        });
    }

    /***************************************************************************/
    /*                          startConversation method                       */
    /* ----------------------------------------------------------------------- */
    /* make your conversation function                                         */
    /* reference - https://botman.io/2.0/conversations#starting-a-conversation */
    /* ----------------------------------------------------------------------- */
    /***************************************************************************/


    public function startConversation(Conversation $instance, $recipient = null, $driver = null)
    {
        $this->bots->startConversation($instance, $recipient, $driver);
    }

    public function on($name, $callback)
    {
        $this->bots->on($name, $callback);
    }


    /**
     * Try to match messages with the ones we should
     * listen to.
     */
    public function listen()
    {
        $this->bots->listen();
    }


    /**
     * @return IncomingMessage
     */
    public function getMessage()
    {
        return $this->bots->getMessage();
    }


    /**
     * @param string|Question $question
     * @param array|Closure $next
     * @param array $additionalParameters
     * @param null|string $recipient
     * @param null|string $driver
     * @return Response
     */
    public function ask($question, $next, $additionalParameters = [], $recipient = null, $driver = null)
    {
        return $this->bots->ask($question, $next, $additionalParameters, $recipient, $driver);
    }


    /**
     * @param string|Question $message
     * @param string|array $recipients
     * @param DriverInterface|null $driver
     * @param array $additionalParameters
     * @return Response
     * @throws BotManException
     */
    public function say($message, $recipients, $driver = null, $additionalParameters = [])
    {
        return $this->bots->say($message, $recipients, $driver, $additionalParameters);
    }

    /**
     * @param string $name The Driver name or class
     */
    public function loadDriver($name)
    {
        $this->bots->loadDriver($name);
    }

    /**
     * @param DriverInterface $driver
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->bots->setDriver($driver);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->bots->getDriver();
    }

    /**
     * Retrieve the chat message.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->bots->getMessages();
    }

    /**
     * Retrieve the chat message that are sent from bots.
     *
     * @return array
     */
    public function getBotMessages()
    {
        return $this->bots->getBotMessages();
    }

    /**
     * @return \BotMan\BotMan\Messages\Incoming\Answer
     */
    public function getConversationAnswer()
    {
        return $this->bots->getConversationAnswer();
    }

    /**
     * @param bool $running
     * @return bool
     */
    public function runsOnSocket($running = null)
    {
        return $this->bots->runsOnSocket($running);
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->bots->getUser();
    }

    /**
     * Listening for image files.
     *
     * @param $callback
     * @return Command
     */
    public function receivesImages($callback)
    {
        return $this->bots->receivesImages($callback);
    }

    /**
     * Listening for image files.
     *
     * @param $callback
     * @return Command
     */
    public function receivesVideos($callback)
    {
        return $this->bots->receivesVideos($callback);
    }

    /**
     * Listening for audio files.
     *
     * @param $callback
     * @return Command
     */
    public function receivesAudio($callback)
    {
        return $this->bots->receivesAudio($callback);
    }

    /**
     * Listening for location attachment.
     *
     * @param $callback
     * @return Command
     */
    public function receivesLocation($callback)
    {
        return $this->bots->receivesLocation($callback);
    }

    /**
     * Listening for files attachment.
     *
     * @param $callback
     * @return Command
     */
    public function receivesFiles($callback)
    {
        return $this->bots->receivesFiles($callback);
    }

    /**
     * Create a command group with shared attributes.
     *
     * @param  array $attributes
     * @param  \Closure $callback
     */
    public function group(array $attributes, Closure $callback)
    {
        $this->bots->group($attributes, $callback);
    }

    /**
     * @return BotMan
     */
    public function types()
    {
        return $this->bots->types();
    }

    /**
     * @param int $seconds Number of seconds to wait
     * @return BotMan
     */
    public function typesAndWaits($seconds)
    {
        return $this->bots->typesAndWaits($seconds);
    }

    /**
     * Low-level method to perform driver specific API requests.
     *
     * @param string $endpoint
     * @param array $additionalParameters
     * @return $this
     * @throws BadMethodCallException
     */
    public function sendRequest($endpoint, $additionalParameters = [])
    {
        return $this->sendRequest($endpoint, $additionalParameters);
    }

    /**
     * @param $payload
     * @return mixed
     */
    public function sendPayload($payload)
    {
        return $this->bots->sendPayload($payload);
    }

    /**
     * Return a random message.
     * @param array $messages
     * @return BotMan
     */
    public function randomReply(array $messages)
    {
        return $this->bots->randomReply($messages);
    }

    /**
     * Make an action for an invokable controller.
     *
     * @param string $action
     * @return string
     * @throws UnexpectedValueException
     */
    protected function makeInvokableAction($action)
    {
        if (! method_exists($action, '__invoke')) {
            throw new UnexpectedValueException(sprintf(
                'Invalid hears action: [%s]', $action
            ));
        }

        return $action.'@__invoke';
    }

    /**
     * @param $callback
     * @return array|string|Closure
     * @throws UnexpectedValueException
     */
    protected function getCallable($callback)
    {
        if ($callback instanceof Closure) {
            return $callback;
        }

        if (is_array($callback)) {
            return $callback;
        }

        if (strpos($callback, '@') === false) {
            $callback = $this->makeInvokableAction($callback);
        }

        list($class, $method) = explode('@', $callback);

        return [new $class($this), $method];
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->bots->getMatches();
    }

    /**
     * @return OutgoingMessage|Question
     */
    public function getOutgoingMessage()
    {
        return $this->bots->getOutgoingMessage();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        return $this->bots->__call($name, $arguments);
    }

    /**
     * Load driver on wakeup.
     */
    public function __wakeup()
    {
        $this->bots->__wakeup();
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return $this->bots->__sleep();
    }



}
