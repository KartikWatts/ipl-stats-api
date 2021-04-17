import { defaultThemes } from "react-data-table-component";

export let playerColumns = [
	{
		name: "Id",
		selector: "player_id",
		omit: true,
	},
	{
		name: "Name",
		selector: "player_name",
		sortable: true,
		grow: 1,
		width: "180px",
		wrap: true,
		style: { color: "#4d82ff", fontWeight: "bold", fontSize: "15px" },
	},
	{
		name: "Team",
		selector: "team_name",
		sortable: true,
		minWidth: "160px",
		grow: 1,
		wrap: true,
		style: { fontWeight: "bold" },
	},
	{
		name: "Matches",
		selector: "matches",
		sortable: true,
	},
	{
		name: "Runs",
		selector: "runs",
		sortable: true,
	},
	{
		name: "Highest",
		selector: "highest_score",
		sortable: true,
	},
	{
		name: "Average",
		selector: "batting_average",
		sortable: true,
	},
	{
		name: "Strike rate",
		selector: "strike_rate",
		sortable: true,
	},
	{
		name: "Hundreds",
		selector: "hundreds",
		sortable: true,
	},
	{
		name: "Fifties",
		selector: "fifties",
		sortable: true,
	},
	{
		name: "Sixes",
		selector: "sixes",
		sortable: true,
	},
	{
		name: "Not outs",
		selector: "not_outs",
		sortable: true,
	},
	{
		name: "Catches",
		selector: "catches",
		sortable: true,
	},
	{
		name: "Overs",
		selector: "overs",
		sortable: true,
	},
	{
		name: "Wickets",
		selector: "wickets",
		sortable: true,
	},
	{
		name: "Average",
		selector: "bowling_average",
		sortable: true,
	},
	{
		name: "Economy",
		selector: "economy",
		sortable: true,
	},
	{
		name: "4 wickets",
		selector: "four_wickets",
		sortable: true,
	},
];

export let ballerColumns = [
	{
		name: "Id",
		selector: "player_id",
		omit: true,
	},
	{
		name: "Name",
		selector: "player_name",
		sortable: true,
		grow: 1,
		width: "180px",
		wrap: true,
		style: { color: "#4d82ff", fontWeight: "bold", fontSize: "15px" },
	},
	{
		name: "Team",
		selector: "team_name",
		sortable: true,
		minWidth: "160px",
		grow: 1,
		wrap: true,
		style: { fontWeight: "bold" },
	},
	{
		name: "Matches",
		selector: "matches",
		sortable: true,
	},
	{
		name: "Overs",
		selector: "overs",
		sortable: true,
	},
	{
		name: "Wickets",
		selector: "wickets",
		sortable: true,
	},
	{
		name: "Average",
		selector: "bowling_average",
		sortable: true,
	},
	{
		name: "Economy",
		selector: "economy",
		sortable: true,
	},
	{
		name: "4 wickets",
		selector: "four_wickets",
		sortable: true,
	},
	{
		name: "Not outs",
		selector: "not_outs",
		sortable: true,
	},
	{
		name: "Catches",
		selector: "catches",
		sortable: true,
	},
	{
		name: "Runs",
		selector: "runs",
		sortable: true,
	},
	{
		name: "Highest",
		selector: "highest_score",
		sortable: true,
	},
	{
		name: "Average",
		selector: "batting_average",
		sortable: true,
	},
	{
		name: "Strike rate",
		selector: "strike_rate",
		sortable: true,
	},
	{
		name: "Hundreds",
		selector: "hundreds",
		sortable: true,
	},
	{
		name: "Fifties",
		selector: "fifties",
		sortable: true,
	},
	{
		name: "Sixes",
		selector: "sixes",
		sortable: true,
	},
];

export const customStyles = {
	headRow: {
		style: {
			borderTopStyle: "solid",
			borderTopWidth: "1px",
			borderTopColor: defaultThemes.default.divider.default,
			background: "rgba(255,230,45,1)",
		},
	},
	headCells: {
		style: {
			"&:not(:last-of-type)": {
				borderRightStyle: "solid",
				borderRightWidth: "1px",
				fontSize: "15px",
				borderRightColor: defaultThemes.default.divider.default,
			},
		},
	},
	cells: {
		style: {
			position: "relative",
			userSelect: "none",
			fontSize: "14px",
			WebkitUserSelect: "none",
			MsUserSelect: "none",
			"&:nth-child(even)": {
				background: "#e9ffb314",
			},
			"&:not(:last-of-type)": {
				borderRightStyle: "solid",
				borderRightWidth: "1px",
				borderRightColor: defaultThemes.default.divider.default,
			},
		},
	},
};

export const activeName = (playerName) => ({
	position: "fixed",
	right: "30px",
	bottom: "60px",
	background: "rgba(128,128,128,0.8",
	zIndex: "2",
	padding: "10px",
	borderRadius: "10px",
	userSelect: "none",
	color: "#ffffff",
	fontSize: "0.8rem",
	fontWeight: "bold",
	transition: "all 0.2s",
	opacity: playerName ? "1" : "0",
});
