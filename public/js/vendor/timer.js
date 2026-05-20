/**
 * Timer function
 *  When instantiated and no parameters has been supplied it will become a stopwatch since the default time is '00:00:00'
 * Dependencies (moment js)
 *
 *
 * @param {String|Number} [time='00:00:00'] Format should be hh:mm:ss. If this is number this
 * should be in milliseconds
 * @param {Boolean} [bIsCountDown=false]
 * @param {Function} [cbEverySecond=function(sHours, sMinutes, sSeconds, otherData)] Callback in every second
 * @param {Function} [cbOnStop=function(otherData)] Callback on stop. Will be called upon triggering the stop function
 * @param {*} [otherData] Other data that needs by the callback
 *
 * @constructor
 */
function Timer(time, bIsCountDown, cbEverySecond, cbOnStop, otherData, oServerTime) {
    "use strict";

    var cThis = this,
        oMomentDuration, oMomentTime, oMomentServerTime, hours, minutes, seconds, nTimer = 0, days, years,
        sHours = '00', sMinutes = '00', sSeconds = '00', sDays = '', sYears = '',
        millisec = 0,
        oDefinedData = otherData,
        sTimerType;

    var DEBUG = true;

    this.timer_data = {};

    function updatePublicTimerData() {
        if (DEBUG) {
            cThis.timer_data = {
                privateData: {
                    oMomentDuration: oMomentDuration,
                    oMomentTime: oMomentTime,
                    oMomentServerTime: oMomentServerTime,
                    hours: hours,
                    minutes: minutes,
                    seconds: seconds,
                    nTimer: nTimer,
                    days: days,
                    years: years,
                    sHours: sHours,
                    sMinutes: sMinutes,
                    sSeconds: sSeconds,
                    sDays: sDays,
                    sYears: sYears,
                    millisec: millisec,
                    sTimerType: sTimerType,
                    oDefinedData: oDefinedData
                },
                parameters: {
                    time: time,
                    bIsCountDown: bIsCountDown,
                    cbEverySecond: cbEverySecond,
                    cbOnStop: cbOnStop,
                    otherData: otherData
                }
            };
        }

    }

    /**
     * Initializes the moment duration and other settings
     */
    function initializeDuration() {
        // assigning default if certain variable is not set properly
        time = (time !== undefined) ? time : '00:00:00';
        bIsCountDown = (bIsCountDown !== undefined) ? bIsCountDown : false;
        cbEverySecond = (cbEverySecond !== undefined && typeof cbEverySecond === 'function') ? cbEverySecond : logger;
        cbOnStop = (cbOnStop !== undefined && typeof  cbOnStop === 'function') ? cbOnStop : logger;

        sTimerType = (bIsCountDown) ? 'subtract' : 'add';

        // oMomentDuration = moment.duration(time);
        oMomentTime = moment(time);
        oMomentServerTime = moment(oServerTime);

        if (oMomentTime < 0) {
            if (console.warn) {
                console.warn('Given time (' + oMomentTime + ') is less than 0');
            } else {
                console.log('Given time (' + oMomentTime + ') is less than 0');
            }
        }

    }

    initializeDuration();
    updatePublicTimerData();

    /**
     * If cbEverySecond is not set this is the default callback
     */
    function logger() {
        //console.log(sHours + ':' + sMinutes + ':' + sSeconds);
        updatePublicTimerData();
    }

    /**
     * Updates or set the defined data.
     *
     * @param {*} oNewData
     */
    this.set_defined_data = function (oNewData) {
        if (oNewData) {
            oDefinedData = oNewData;
        }
    };

    /**
     * Sets the time of the timer
     *  When called, it will override the instantiated time
     *
     * @param {String} newTime
     */
    this.set_time = function (newTime) {
        clearInterval(nTimer);
        time = newTime;
        initializeDuration();
    };

    /**
     * Set a new callback when stopped
     * NOTE: Upon calling this, you need to start again the timer
     *
     * @param {Function} onStop
     */
    this.set_callback_on_stop = function (onStop) {
        cbOnStop = onStop;
        clearInterval(nTimer);
        updatePublicTimerData();
    };

    /**
     * Returns milliseconds of the current timer
     *
     * @return {Number}
     */
    this.get_milliseconds = function () {
        return millisec;
    };

    /**
     * Returns the current hours
     * Format hh. Example 56
     *
     * @return {String}
     */
    this.get_hours = function () {
        return sHours;
    };

    /**
     * Returns the current minutes
     * Format mm. Example 10
     *
     * @return {String}
     */
    this.get_minutes = function () {
        return sMinutes;
    };

    /**
     * Returns the current seconds
     * Format mm. Example 10
     *
     * @return {String}
     */
    this.get_seconds = function () {
        return sSeconds;
    };

    /**
     * Returns the current duration of the time
     * Format hh:mm:ss. Example 10:59:10
     *
     * @return {String}
     */
    this.get_duration = function () {
        return sHours + ':' + sMinutes + ':' + sSeconds;
    };

    /**
     * Starts the timer
     */
    this.start = function () {
        clearInterval(nTimer);
        nTimer = setInterval(function () {
            // previous computation
            // oMomentDuration[sTimerType](1, 's');

            // days = oMomentDuration.days();
            // hours = oMomentDuration.hours();
            // minutes = oMomentDuration.minutes();
            // seconds = oMomentDuration.seconds();

            oMomentTime[sTimerType](1, 's');

            var oTimeDiff = oMomentServerTime.diff(oMomentTime, 'milliseconds');

            // get total seconds between the times
            var delta = Math.abs(oTimeDiff) / 1000;

            // calculate (and subtract) whole years
            years = Math.floor(delta / 31536000);
            delta -= years * 31536000;

            // calculate (and subtract) whole days
            days = Math.floor(delta / 86400);
            delta -= days * 86400;

            // calculate (and subtract) whole hours
            hours = Math.floor(delta / 3600) % 24;
            delta -= hours * 3600;

            // calculate (and subtract) whole minutes
            minutes = Math.floor(delta / 60) % 60;
            delta -= minutes * 60;

            // what's left is seconds
            seconds = delta % 60;  // in theory the modulus is not required

            millisec = seconds * 1000;

            if (years > 0) {
                sYears = years <= 1 ? years + " y " : years + " y ";
            } else {
                sYears = '';
            }

            if (days > 0) {
                sDays = days <= 1 ? days + " d " : days + " d ";
            } else {
                sDays = '';
            }

            sHours = hours < 10 ? "0" + hours : hours;
            sMinutes = minutes < 10 ? "0" + minutes : minutes;
            sSeconds = seconds < 10 ? "0" + seconds : seconds;

            if (years <= 0 && days <= 0 && hours <= 0 && minutes <= 0 && seconds <= 0) {
                sHours = sMinutes = sSeconds = '00';
                sDays = sYears = '';
                cThis.stop();
            }

            cbEverySecond({yr:sYears, d:sDays, hr:sHours, mn:sMinutes, se:sSeconds}, oDefinedData);
            updatePublicTimerData();
        }, 1000);
    };

    /**
     * Stops the timer
     *
     * @param {Boolean} [bWithOnStopCallback=true]
     */
    this.stop = function (bWithOnStopCallback) {
        clearInterval(nTimer);

        bWithOnStopCallback = (bWithOnStopCallback !== undefined) ? bWithOnStopCallback : true;
        if (bWithOnStopCallback) {
            cbOnStop({yr:sYears, d:sDays, hr:sHours, mn:sMinutes, se:sSeconds}, oDefinedData);
        }
    };

    /**
     * Resets the timer. This also calls the stop function
     *   If you want to start again the timer just call the start function
     */
    this.reset = function () {
        clearInterval(nTimer);
        // oMomentDuration = moment.duration(time);
        oMomentTime = moment(time);
        updatePublicTimerData();
    };
}