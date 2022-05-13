<?php

namespace Nagarro\SmsNotification\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Nagarro\SmsNotification\Model\SmsNotification\Source\SmsGateways;
use Nagarro\SmsNotification\Helper\Data as Helper;

class MessageParser extends AbstractHelper
{
    protected $helper;

    /**
     * @var array
     */
    protected $vars;

    /**
     * @var string
     */
    protected $template;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Helper $helper

    ) {
        parent::__construct($context);
        $this->helper = $helper;
    }

    public function parseMessage($message)
    {
        return $message;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return string
     */

    public function parseTemplate($template, $vars = [])
    {
        $this->template = $template;
        $this->vars = $vars;

        if (preg_match_all('/({{[^{}]*}})/', $template, $matches) > 0) {
            $matches = $this->trimVariableMatches($matches[0]);

            foreach ($matches as $match) {
                $this->template = $this->replacePlaceholderWithVariable($match);
            }
        }

        return $this->template;
    }

    protected function trimVariableMatches($matches)
    {
        $result = [];

        foreach ($matches as $match) {
            $result[] = substr($match, 2, (strlen($match) - 4));
        }

        return $result;
    }

    protected function replacePlaceholderWithVariable($placeholder)
    {
        if (!array_key_exists($placeholder, $this->vars)) {
            return str_replace('{{' . $placeholder . '}}', '', $this->template);
        }
        if (!is_array($this->vars[$placeholder])) {
            return str_replace(
                '{{' . $placeholder . '}}',
                $this->vars[$placeholder],
                $this->template
            );
        }
        if (is_array($this->vars[$placeholder])) {
            return str_replace(
                '{{' . $placeholder . '}}',
                implode(', ', $this->vars[$placeholder]),
                $this->template
            );
        }

        return $this->template;
    }
}
