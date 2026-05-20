var oPusher = new Pusher(my_platform.config('pusher.app.key'), {
    authEndpoint: my_platform.config('pusher.auth.uri'),
    auth: {
        headers:{
            'X-CSRF-TOKEN': my_platform.config('csrf.token')
        }
    },
    cluster: 'ap1',
    encrypted: true
});


var oSubscriptions = {};

// ************************************


function CWebSocket () {};

/**
 *		Class that will be used as the wrapper of the websocket class.
 *		This will be used to subscribe, to bind event and to listen to the callbacks.
 *		This is built for pusher-patterened event and channel binding
 */
(function(){

    /**
     *	@datastructure:
     *
     *		oChannels = { 'channel_name' : 'channel_instance' };
     *
     */
    var oChannels = {}; // will be used to hold the channels

    /**
     * Function that will be used to subscribe in a socket channel.
     *
     *	@param: {string} sChannel
     *	@return: {object} The instance of the channel.
     */
    function subscribeToChannel (sChannel)
    {
        if ( typeof (sChannel) != 'undefined' && sChannel.length > 0)
        {
            var
                bExists = channelExists(sChannel), // check if the channel is already existing in the channel list.
                oChannelInstance = null;

            // if not, create new channel instance.
            if ( ! bExists)
            {
                oChannelInstance = oPusher.subscribe(sChannel);

                if(typeof(oSubscriptions) != 'undefined')
                {
                    oChannels[sChannel] = oChannelInstance; //variable to hold all subscriptions
                    ////console.log(oChannels)
                }

            } else {
                oChannelInstance = oChannels[sChannel];
            }

            return oChannelInstance;// return the instance of the channel
        }
    }


    /**
     *	The function that will be used to bind event and receive callback from the user.
     *
     *	@param: {string} sEventName - The name of the event to be bounded
     *	@param: {string} sChannelName - The name of the channel where to bind the event
     *	@param: {function} fnCalback - The callback function that will be invoked upon trigger of the event
     *
     *	@return: none
     */
    function bindEvent (sEventName, sChannelName, fnCallback)
    {
        if (typeof (sEventName) != 'undefined' && typeof (sChannelName) != 'undefined')
        {
            var oChannelInstance = null;
            if (channelExists(sChannelName)) // check if the channel is already existing in the list.
            {
                oChannelInstance = oChannels[sChannelName];
            } else { // if not existing,
                oChannelInstance = subscribeToChannel(sChannelName); // create new channel instance.
            }

            //oChannelInstance.unbind(sEventName);
            //prevent rebinding of events except

            if(sChannelName != 'presence-ironman' || (sChannelName == 'presence-ironman' && (sEventName == 'messenger_send' || sEventName == 'messenger_seen')))
            {
                oChannelInstance.unbind(sEventName)
            }

            oChannelInstance.bind(sEventName, function(data) // bind event based on the given event
            {
                if (typeof (fnCallback) == 'function')
                {
                    fnCallback(data); // set callback based on the callback parameter. (No validation on the native callback)
                }


                /* for benchmarking */
                /*if (typeof (data) == 'string')
                 {
                 data = $.parseJSON(data);
                 }*/
                /*  var oDisplayData = {};

                 oDisplayData = $.parseJSON(data.display_data);

                 try{
                 var time = oDisplayData.timestamp;
                 var ms = 0;
                 var h = 0;
                 var m = 0;
                 var s = 0;
                 var arrTime = time.split(":");
                 h = arrTime[0];
                 m = arrTime[1];

                 var millisec = arrTime[2].split(".");

                 if (typeof (millisec[1]) != 'undefined')
                 {
                 s = millisec[0];
                 ms = millisec[1];
                 }
                 console.log("HERE");
                 var date2 = new Date();
                 var date1 = new Date(date2.getFullYear(), date2.getMonth(), date2.getDay() +1,  h, m, s,ms);
                 if (date2 < date1) {
                 date2.setDate(date2.getDate() + 1);
                 }
                 console.log(" 2");
                 var diff = date2 - date1;


                 $("#benchmark-realtime-update").html("<div>Real time update : " + diff + "</div>");
                 }catch (e)
                 {

                 } */
            });

        }
    }

    /**
     *	The function that will check the existence of the channel in the list based on the given channel name
     *	@param: {string} sChannelName - The name of the channel that will be validated.
     * 	@return: {boolean} bExist - True if existing false if not.
     */

    function channelExists(sChannelName)
    {
        var bExisting = false;
        if (typeof (sChannelName) != 'undefined' && typeof (oChannels[sChannelName]) != 'undefined')// check existence in the oChannels
        {
            // return true if existing, false if not.
            bExisting = true;
        }

        return bExisting;
    }

    CWebSocket.prototype.subscribe = function (sChannel)
    {
        return subscribeToChannel(sChannel);
    };



    CWebSocket.prototype.bind = function (oData)
    {
        return bindEvent(oData.event, oData.channel, oData.callback);
    };


})();

var oSock = new CWebSocket;


