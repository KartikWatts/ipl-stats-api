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
