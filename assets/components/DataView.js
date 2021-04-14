import { nominalTypeHack } from "prop-types";
import React, { useEffect, useMemo, useState } from "react";
import DataTable, { defaultThemes } from "react-data-table-component";
import { playerColumns } from "../helpers/columns";

const DataView = ({ data, teamData, id }) => {
	// console.log(data);
	const [listData, setListData] = useState(data);
	const [loading, setLoading] = useState(true);
	const [playerName, setPlayerName] = useState(null);

	const customStyles = {
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
		activeName: {
			position: "fixed",
			right: "30px",
			bottom: "60px",
			background: "#80808075",
			zIndex: "2",
			padding: "10px",
			borderRadius: "10px",
			userSelect: "none",
			color: "rgb(0 64 214)",
			fontSize: "0.8rem",
			fontWeight: "bold",
			transition: "all 0.2s",
			opacity: playerName ? "1" : "0",
		},
	};

	const handleSort = async (column, sortDirection) => {
		setLoading(true);
		if (
			column.selector == "player_name" ||
			column.selector == "team_name"
		) {
			let data = [];
			listData.map((item) => {
				data.push(item);
			});

			data = await data.sort((a, b) => {
				let nameA = a[column.selector].toUpperCase();
				let nameB = b[column.selector].toUpperCase();
				if (nameA < nameB) {
					if (sortDirection == "asc") return -1;
					else return 1;
				}
				if (nameA > nameB) {
					if (sortDirection == "asc") return 1;
					else return -1;
				}
				return 0;
			});
			setListData(data);
			setLoading(false);
			return;
		}
		let data = [],
			others = [];
		listData.map((item) => {
			if (item[column.selector] != "-") {
				data.push(item);
			} else {
				others.push(item);
			}
		});
		data = await data.sort((a, b) => {
			if (sortDirection == "asc") {
				return (
					parseFloat(a[column.selector]) -
					parseFloat(b[column.selector])
				);
			} else {
				return (
					parseFloat(b[column.selector]) -
					parseFloat(a[column.selector])
				);
			}
		});
		data.push(...others);
		setListData(data);
		setLoading(false);
	};

	const getPlayerName = (e) => {
		setPlayerName(e.player_name);

		setTimeout(() => {
			setPlayerName(null);
		}, 800);
	};

	useEffect(() => {
		if (id == 0) {
			setLoading(true);
			const newList = data.filter((item) => item.matches != null);
			if (data && teamData) {
				for (let i = 0; i < newList.length; i++) {
					const teamName = teamData.find(
						(el) => el.id == newList[i]["team_id"]
					);
					teamName = teamName["name"];
					newList[i].team_name = teamName;
				}
				// console.log(newList);
				setListData(newList);
				setLoading(false);
			}
		}
	}, [data, teamData, id]);

	useEffect(() => {
		if (id == 0) {
			return;
		}
		setLoading(true);
		let newData = data;
		const newList = newData.filter((item) => item.team_id == id);
		setListData(newList);
		setLoading(false);
	}, [id]);

	let name = <div style={customStyles.activeName}>{playerName}</div>;

	const columns = useMemo(() => playerColumns, []);

	return (
		<>
			<DataTable
				columns={columns}
				data={listData}
				keyField="player_id"
				striped
				highlightOnHover
				pointerOnHover
				// defaultSortField="player_name"
				fixedHeader
				customStyles={customStyles}
				pagination
				progressPending={loading}
				persistTableHead
				onSort={handleSort}
				sortServer
				onRowClicked={(e) => getPlayerName(e)}
			/>
			{name}
		</>
	);
};

export default DataView;
