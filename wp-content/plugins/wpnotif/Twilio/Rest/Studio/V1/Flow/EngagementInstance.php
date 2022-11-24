<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string sid
 * @property string accountSid
 * @property string flowSid
 * @property string contactSid
 * @property string contactChannelAddress
 * @property array context
 * @property string status
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string url
 * @property array links
 */
class EngagementInstance extends InstanceResource {
	protected $_steps = null;
	protected $_engagementContext = null;

	/**
	 * Initialize the EngagementInstance
	 *
	 * @param \Twilio\Version $version Version that contains the resource
	 * @param mixed[] $payload The response payload
	 * @param string $flowSid Flow Sid.
	 * @param string $sid Engagement Sid.
	 *
	 * @return \Twilio\Rest\Studio\V1\Flow\EngagementInstance
	 */
	public function __construct( Version $version, array $payload, $flowSid, $sid = null ) {
		parent::__construct( $version );

		// Marshaled Properties
		$this->properties = array(
			'sid'                   => Values::array_get( $payload, 'sid' ),
			'accountSid'            => Values::array_get( $payload, 'account_sid' ),
			'flowSid'               => Values::array_get( $payload, 'flow_sid' ),
			'contactSid'            => Values::array_get( $payload, 'contact_sid' ),
			'contactChannelAddress' => Values::array_get( $payload, 'contact_channel_address' ),
			'context'               => Values::array_get( $payload, 'context' ),
			'status'                => Values::array_get( $payload, 'status' ),
			'dateCreated'           => Deserialize::dateTime( Values::array_get( $payload, 'date_created' ) ),
			'dateUpdated'           => Deserialize::dateTime( Values::array_get( $payload, 'date_updated' ) ),
			'url'                   => Values::array_get( $payload, 'url' ),
			'links'                 => Values::array_get( $payload, 'links' ),
		);

		$this->solution = array( 'flowSid' => $flowSid, 'sid' => $sid ?: $this->properties['sid'], );
	}

	/**
	 * Fetch a EngagementInstance
	 *
	 * @return EngagementInstance Fetched EngagementInstance
	 * @throws TwilioException When an HTTP error occurs.
	 */
	public function fetch() {
		return $this->proxy()->fetch();
	}

	/**
	 * Generate an instance context for the instance, the context is capable of
	 * performing various actions.  All instance actions are proxied to the context
	 *
	 * @return \Twilio\Rest\Studio\V1\Flow\EngagementContext Context for this
	 *                                                       EngagementInstance
	 */
	protected function proxy() {
		if ( ! $this->context ) {
			$this->context = new EngagementContext(
				$this->version,
				$this->solution['flowSid'],
				$this->solution['sid']
			);
		}

		return $this->context;
	}

	/**
	 * Deletes the EngagementInstance
	 *
	 * @return boolean True if delete succeeds, false otherwise
	 * @throws TwilioException When an HTTP error occurs.
	 */
	public function delete() {
		return $this->proxy()->delete();
	}

	/**
	 * Magic getter to access properties
	 *
	 * @param string $name Property to access
	 *
	 * @return mixed The requested property
	 * @throws TwilioException For unknown properties
	 */
	public function __get( $name ) {
		if ( array_key_exists( $name, $this->properties ) ) {
			return $this->properties[ $name ];
		}

		if ( property_exists( $this, '_' . $name ) ) {
			$method = 'get' . ucfirst( $name );

			return $this->$method();
		}

		throw new TwilioException( 'Unknown property: ' . $name );
	}

	/**
	 * Provide a friendly representation
	 *
	 * @return string Machine friendly representation
	 */
	public function __toString() {
		$context = array();
		foreach ( $this->solution as $key => $value ) {
			$context[] = "$key=$value";
		}

		return '[Twilio.Studio.V1.EngagementInstance ' . implode( ' ', $context ) . ']';
	}

	/**
	 * Access the steps
	 *
	 * @return \Twilio\Rest\Studio\V1\Flow\Engagement\StepList
	 */
	protected function getSteps() {
		return $this->proxy()->steps;
	}

	/**
	 * Access the engagementContext
	 *
	 * @return \Twilio\Rest\Studio\V1\Flow\Engagement\EngagementContextList
	 */
	protected function getEngagementContext() {
		return $this->proxy()->engagementContext;
	}
}