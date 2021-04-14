import React, { useEffect, useState } from "react";
import BallLoader from "../components/BallLoader";
import HorizontalLoader from "../components/HorizontalLoader";
import SelectSquad from "../components/SelectSquad";
import img1 from "../images/1.png";
import img3 from "../images/3.png";
import img4 from "../images/4.png";
import img5 from "../images/5.png";
import img6 from "../images/6.png";
import img8 from "../images/8.png";
import img9 from "../images/9.png";
import img62 from "../images/62.png";
import DataView from "../components/DataView";

let link = "https://iplt20-stats.herokuapp.com";
let url1 = `${link}/api/squads-list`;
let url2 = `${link}/api/all-players-list`;

const getImg = (id) => {
	switch (id) {
		case 1:
			return img1;
		case 3:
			return img3;
		case 4:
			return img4;
		case 5:
			return img5;
		case 6:
			return img6;
		case 8:
			return img8;
		case 9:
			return img9;
		case 62:
			return img62;

		default:
			break;
	}
};

const SelectionBar = () => {
	const [isLoaded, setIsLoaded] = useState(0);
	const [teamData, setTeamData] = useState(null);
	const [selectedPointer, setSelectedPointer] = useState(-1);

	const [isPlayersLoaded, setIsPlayersLoaded] = useState(0);
	const [playersData, setPlayersData] = useState(null);

	const getSelected = (index) => {
		setSelectedPointer(index);
	};

	let squadData = (
		<div className="squad-list squad-select">
			<HorizontalLoader />
		</div>
	);

	if (isLoaded == 1) {
		squadData = (
			<div className="squad-list">
				{teamData &&
					teamData.map((data, i) => {
						return (
							<SelectSquad
								key={data.id}
								squad={data.id}
								index={i}
								img={getImg(data.id)}
								name={data.name}
								onClick={() => getSelected(i)}
								selectedIndex={selectedPointer}
							/>
						);
					})}
			</div>
		);
	} else if (isLoaded == 2) {
		squadData = <h3>Oops! couldn't load data. Something went wrong.</h3>;
	}

	const getSquadData = async () => {
		let response = await fetch(url1);
		if (response.status == 200) {
			setIsLoaded(1);
			let resJSON = await response.json();
			setTeamData(resJSON);
		} else {
			setIsLoaded(2);
		}
	};

	const getPlayersData = async () => {
		let response = await fetch(url2, {
			method: "POST",
			cache: "no-cache",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({ secret_key: "ramramram" }),
		});
		if (response.status == 200) {
			setIsPlayersLoaded(1);
			let resJSON = await response.json();
			let filteredData = resJSON.filter((item) => item.matches != null);
			setPlayersData(filteredData);
		} else {
			setIsPlayersLoaded(2);
		}
	};

	let playersTotalData = (
		<div>
			<BallLoader />
		</div>
	);

	if (isPlayersLoaded == 1) {
		if (selectedPointer === -1) {
			playersTotalData = <span className="data-head__emp">All</span>;
		} else {
			playersTotalData = (
				<span className="data-head__emp">
					{teamData[selectedPointer]["name"]}
				</span>
			);
		}
	} else if (isPlayersLoaded == 2) {
		playersTotalData = "Oops! couldn't load data. Something went wrong.";
	}

	useEffect(() => {
		getSquadData();
		getPlayersData();
	}, []);

	return (
		<>
			<section className="selection-bar">
				<SelectSquad
					squad="ALL"
					onClick={() => getSelected(-1)}
					selectedIndex={selectedPointer}
				/>
				{squadData}
			</section>
			<div className="data-head">
				{isPlayersLoaded == 1 && "Data for"} {playersTotalData}
			</div>
			{playersData && (
				<DataView
					data={playersData}
					teamData={teamData}
					id={
						selectedPointer != -1
							? teamData[selectedPointer]["id"]
							: 0
					}
				/>
			)}
		</>
	);
};

export default SelectionBar;
