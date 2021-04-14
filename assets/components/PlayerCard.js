import React from "react";
import noPic from "../images/no-photo.png";

const CardData = ({ data, value }) => {
	return (
		<div>
			<span className="body-row__data">{data}: </span>
			<span className="body-row__value">{value}</span>
		</div>
	);
};

const PlayerCard = ({ data }) => {
	console.log(data);
	return (
		<div className="player-card">
			<object
				data={data.image_url}
				type="image/png"
				className="player-card__image"
			>
				<img
					className="player-card__image2 "
					src={noPic}
					alt={data.player_name}
				/>
			</object>
			<div className="card-data">
				<div className="card-head">
					{data.player_name}{" "}
					<span className="card-head__team">{data.team_name} </span>
				</div>
				<div className="card-body">
					<div className="card-body__row">
						<CardData data="Matches" value={data.matches} />
						<CardData data="Runs" value={data.runs} />
						<CardData data="Highest" value={data.highest_score} />
						<CardData
							data="Bat Average"
							value={data.batting_average}
						/>
						<CardData data="Strike Rate" value={data.strike_rate} />
					</div>
					<div className="card-body__row">
						<CardData data="Hundreds" value={data.hundreds} />
						<CardData data="Fifties" value={data.fifties} />
						<CardData data="Sixes" value={data.sixes} />
						<CardData data="Not Outs" value={data.not_outs} />
						<CardData data="Catches" value={data.catches} />
					</div>
					<div className="card-body__row">
						<CardData data="Overs" value={data.overs} />
						<CardData data="Wickets" value={data.wickets} />
						<CardData
							data="Bowl Average"
							value={data.bowling_average}
						/>
						<CardData data="Economy" value={data.economy} />
						<CardData data="4 Wickets" value={data.four_wickets} />
					</div>
				</div>
			</div>
		</div>
	);
};

export default PlayerCard;
