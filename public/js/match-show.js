var iconLive = {
    match_start_end: 'icon-live-01',
    offside: 'icon-live-02',
    yellow_card: 'icon-live-03',
    red_card: 'icon-live-04',
    pitch: 'icon-live-05',
    score: 'icon-live-06',
    own_goal: 'icon-live-07',
    corner: 'icon-live-08',
    substitution: 'icon-live-09',
    free_kick: 'icon-live-10'
};
var blankIcon = $('#match-events').data('icon');

function getIconLive(icon) {
    if (icon) {
        return iconLive[icon];
    }
    return 'icon-dot-live';
}

var Event = React.createClass({
    render: function () {
        return (
            <div className="event">
                <div className="minutes">
                    <span className="text-minutes ">{this.props.time}</span>
                    <img className={"icon-live" + ' ' + this.props.icon} src={blankIcon}/>
                </div>
                <div className="text-live">
                    <strong>{this.props.title}</strong>
                    <p>{this.props.children.toString()}</p>
                </div>
                <div className="clear"></div>
            </div>
        );
    }
});

var EventBox = React.createClass({
    getEvents: function () {
        $.ajax({
            type: 'GET',
            url: this.props.url,
            cache: false,
            success: function (data, status) {
                this.setState({data: data});
            }.bind(this)
        });
    },
    getInitialState() {
        return {data: []}
    },
    componentDidMount: function () {
        //call automatically after a component is rendered.
        this.getEvents();
        setInterval(this.getEvents, this.props.pollInterval);
    },
    render: function () {
        return (
            <div className="eventBox">
                <h3>Events</h3>
                <EventList data={this.state.data}/>
            </div>
        )
    }
});

var EventList = React.createClass({
    render: function () {
        var eventNodes = this.props.data.map(function (event) {
            return (
                <Event key={event.id} title={event.title} time={event.time} image={event.image} icon={event.icon}>
                    {event.content}
                </Event>
            )
        });
        return (
            <div className="eventList">
                {eventNodes}
            </div>
        )
    }
});

var url = $('#match-events').data('url');
var matchId = $('#match-events').data('match-id');
ReactDOM.render(
    <EventBox url={url} pollInterval={2000} matchId={matchId}/>,
    document.getElementById('match-events')
);
