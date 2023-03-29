const net = require('net');

// Connect to the Asterisk Manager Interface
const ami = net.createConnection({
    host: '192.168.2.178',
    port: 5038
});

// Authenticate with the Asterisk Manager Interface
ami.on('connect', () => {
    ami.write('Action: Login\r\n');
    ami.write('Username: cresmanager\r\n');
    ami.write('Secret: grasya\r\n');
    ami.write('\r\n');
});

// Listen for incoming call events
ami.on('data', data => {
    const event = data.toString().split('\r\n').reduce((result, line) => {
        const [key, value] = line.split(': ');
        result[key] = value;
        return result;
    }, {});

    if (event.Event === 'Newchannel' && event.ChannelStateDesc === 'Ring') {
        const callerIdNum = event.CallerIDNum;
        const uniqueId = event.Uniqueid;

        // Do something with the caller ID number and unique ID, such as create a new lead in SuiteCRM
        console.log(`Incoming call from ${callerIdNum} (unique ID: ${uniqueId})`);
    }
});
