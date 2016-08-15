
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
            <div className='event'>
                <div className='minutes'>
                    <span className='text-minutes '>
                        <a href={'/admin/match-events/' + this.props.id + '/edit'}>{this.props.time}</a>
                    </span>
                    <img className={'icon-live' + ' ' + this.props.icon} src={blankIcon}/>
                </div>
                <div className='text-live'>
                    <strong>{this.props.title}</strong>
                    <p>{this.props.children.toString()}</p>
                </div>
                <div className='clear'></div>
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
    handleEventSubmit: function (event) {
        $.ajax({
            type: 'POST',
            url: '/admin/match-events',
            data: event,
            success: function (data) {
                this.setState({data: data});
            }.bind(this),
            error: function (xhr, status, err) {
                this.setState({data: eventList});
                console.error(this.props.url, status, err.toString());
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
            <div className='eventBox'>
                <h3>Events</h3>
                <EventForm matchId={this.props.matchId} onEventSubmit={this.handleEventSubmit}/>
                <EventList data={this.state.data}/>
            </div>
        )
    }
});

var EventList = React.createClass({
    render: function () {
        var eventNodes = this.props.data.map(function (event) {
            return (
                <Event key={event.id} id={event.id} title={event.title} time={event.time} image={event.image} icon={event.icon}>
                    {event.content}
                </Event>
            )
        });
        return (
            <div className='eventList'>
                {eventNodes}
            </div>
        )
    }
});

var eventTypes = $('#match-events').data('event-type');
var placeHolders = $('#match-events').data('placeholder');

var EventForm = React.createClass({
    getInitialState: function () {
        return {content: '', match_id: '', title: '', icon: '', time: ''}
    },
    handleTimeChange: function (e) {
        this.setState({time: e.target.value})
    },
    handleContentChange: function (e) {
        this.setState({content: e.target.value})
    },
    handleTitleChange: function (e) {
        this.setState({title: e.target.value})
    },
    handleIconChange: function (e) {
        this.setState({icon: e.target.value})
    },
    handleSubmit: function (e) {
        e.preventDefault();
        var time = this.state.time;
        var content = this.state.content.trim();
        var title = this.state.title.trim();
        var icon = getIconLive(this.state.icon);
        if (!content) {
            return;
        }
        //send request to server
        this.props.onEventSubmit({
            content: content,
            match_id: this.props.matchId,
            title: title,
            icon: icon,
            time: time
        });
        this.setState({content: '', title: '', icon: '', time: ''});
    },
    render: function () {
        return (
            <form className='eventForm' onSubmit={this.handleSubmit}>
                <input className='form-control ' type='text' placeholder={placeHolders.title} value={this.state.title}
                       onChange={this.handleTitleChange}/>
                <textarea className='form-control' type='text' placeholder={placeHolders.content}
                          value={this.state.content}
                          onChange={this.handleContentChange}/>
                <input className='form-control sub-form col-sm-6' type='number' placeholder={placeHolders.event_time}
                       value={this.state.time} onChange={this.handleTimeChange}/>
                <select className='form-control sub-form col-sm-6' value={this.state.icon}
                        onChange={this.handleIconChange}>
                    <option value=''>{placeHolders['choose_one']}</option>
                    <option value='match_start_end'>{eventTypes['match_start_end']}</option>
                    <option value='offside'>{eventTypes['offside']}</option>
                    <option value='yellow_card'>{eventTypes['yellow_card']}</option>
                    <option value='red_card'>{eventTypes['red_card']}</option>
                    <option value='pitch'>{eventTypes['pitch']}</option>
                    <option value='score'>{eventTypes['score']}</option>
                    <option value='own_goal'>{eventTypes['own_goal']}</option>
                    <option value='corner'>{eventTypes['corner']}</option>
                    <option value='substitution'>{eventTypes['substitution']}</option>
                    <option value='free_kick'>{eventTypes['free_kick']}</option>
                </select>
                <input className='btn btn-default' type='submit' value='Post'/>
            </form>
        )
    }
});

var url = $('#match-events').data('url');
var matchId = $('#match-events').data('match-id');
ReactDOM.render(
    <EventBox url={url} pollInterval={2000} matchId={matchId}/>,
    document.getElementById('match-events')
);
