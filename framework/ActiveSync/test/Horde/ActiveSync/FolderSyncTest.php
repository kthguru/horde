<?php
/* 
 * Unit tests for the various foldersync requests.
 *
 * @author Michael J. Rubinsky <mrubinsk@horde.org>
 * @category Horde
 * @package ActiveSync
 */
class Horde_ActiveSync_FolderSyncTest extends Horde_Test_Case
{
    /**
     * Setup shared fixtures
     */
    public function setUp()
    {
        $this->markTestIncomplete('Needs fixing.');

        /* Mock the registry */
        $this->_registry = $this->getMockSkipConstructor('Horde_Registry');

        /* A real state object */
        $state = new Horde_ActiveSync_State_File(array('directory' => './test_state'));

        /* Mock the connector, and provide the data for the listApis call */
        $this->_connector = $this->getMockSkipConstructor('Horde_ActiveSync_Driver_Horde_Connector_Registry');
        $this->_connector->expects($this->once())
                ->method('horde_listApis')
                ->will($this->returnValue(array('horde', 'contacts', 'calendar', 'tasks')));

        /* Horde driver */
        $this->_driver = new Horde_ActiveSync_Driver_Horde(array('connector' => $this->_connector,
                                                          'state_basic' => $state));
        /* Mock the request object */
        $this->_request = $this->getMockSkipConstructor('Horde_Controller_Request_Http', array('getGetParams', 'getHeader'));

        /* Output stream */
        $this->_output = fopen('php://memory', 'w+');

        /* We mock the startWBXML() method since it sends out a content-type header
         * that breaks the test output */
        $this->_encoder = $this->getMock('Horde_ActiveSync_Wbxml_Encoder', array('startWBXML'), array($this->_output));
        $this->_encoder->expects($this->once())->method('startWBXML')->will($this->returnCallback(array($this, 'wbxmlHeader')));

        /* Logger */
        //$this->_logfile = fopen('log.txt', 'a');
    }

    /**
     * Tests initial foldersync command.
     *
     */
    public function testInitialFolderSync()
    {
        /* Initial requests should call the following, in this order */
        $this->_request->expects($this->once())->method('getGetParams')->will($this->returnValue(array('DeviceType' => 'HordeTestSuite')));
        $this->_request->expects($this->at(1))->method('getHeader')->with($this->equalTo('User-Agent'))->will($this->returnValue('ActiveSyncTestClient'));
        $this->_request->expects($this->at(2))->method('getHeader')->with($this->equalTo('MS-ASProtocolVersion'))->will($this->returnValue('2.5'));
        $this->_request->expects($this->at(3))->method('getHeader')->with($this->equalTo('X-MS-PolicyKey'))->will($this->returnValue('0'));

        /* Mock php input stream */
        $input = fopen(__DIR__ . '/fixtures/FolderSyncRequest.txt', 'r');

        $as = new Horde_ActiveSync($this->_driver,
                                   new Horde_ActiveSync_Wbxml_Decoder($input),
                                   $this->_encoder,
                                   $this->_request);

        /* Set up the server and handle the request */
        $as->setLogger(new Horde_Log_Logger(new Horde_Log_Handler_Null($this->_logfile)));
        $as->setProvisioning(false);
        $as->handleRequest('FolderSync', 'testid');

        /* Test output - get the last generated synckey so we can compare */
        $key = $this->_driver->getStateObject()->getCurrentSyncKey();

        /* Expected wbxml output */
        $expected = chr(0x03) . chr(0x01) . 'j' . chr(0x00) . chr(0x00) .
            chr(0x07) . 'VL' . chr(0x03) . '1' . chr(0x00) . chr(0x01) . 'R' .
            chr(0x03) . $key . chr(0x00) . chr(0x01) . 'NW' . chr(0x03) .
            '3 OH' . chr(0x03) . 'Tasks' . chr(0x00) . chr(0x01) .
            'I0 GTasks J7 OHContacts I0 GContacts J9 OHCalendar I0 GCalendar J8 ';
        rewind($this->_output);
        $received = stream_get_contents($this->_output);
        $this->assertEquals($expected, $received);
    }

    /**
     * Tests the second pim->server foldersync request. This is the request
     * sent after the pim receives the first synckey
     */
    public function testFolderSyncWithKey()
    {
        $this->markTestIncomplete('TODO');
    }

    public function wbxmlHeader()
    {
        $this->_encoder->outputWbxmlHeader();
    }

    public function tearDown()
    {
        fclose($this->_output);
        //fclose($this->_logfile);
        `rm -rf ./test_state`;
    }
}
