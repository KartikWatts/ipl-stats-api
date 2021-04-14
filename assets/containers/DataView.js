import React, { useEffect, useMemo, useState } from "react";
import DataTable from "react-data-table-component";
import { playerColumns, customStyles, activeName } from "../helpers/columns";
import FilterComponent from "../components/FilterComponent";
import PlayerCard from "../components/PlayerCard";

const DataView = ({ data, teamData, id }) => {
	const [listData, setListData] = useState(data);
	const [loading, setLoading] = useState(true);
	const [playerName, setPlayerName] = useState(null);
	const [filterText, setFilterText] = useState("");
	const [resetPaginationToggle, setResetPaginationToggle] = useState(false);

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

	const columns = useMemo(() => playerColumns, []);

	let name = <div style={activeName(playerName)}>{playerName}</div>;

	const handleClear = () => {
		if (filterText) {
			setResetPaginationToggle(!resetPaginationToggle);
			setFilterText("");
		}
	};
	const filteredItems = data.filter(
		(item) =>
			item.player_name &&
			item.player_name.toLowerCase().includes(filterText.toLowerCase())
	);

	return (
		<div>
			<FilterComponent
				onFilter={(e) => setFilterText(e.target.value)}
				onClear={handleClear}
				filterText={filterText}
			/>
			<DataTable
				columns={columns}
				data={filterText.length == 0 ? listData : filteredItems}
				keyField="player_id"
				noHeader
				striped
				highlightOnHover
				pointerOnHover
				defaultSortField="player_name"
				fixedHeader
				customStyles={customStyles}
				pagination
				paginationResetDefaultPage={resetPaginationToggle}
				progressPending={loading}
				persistTableHead
				onSort={handleSort}
				sortServer
				subHeaderComponent={<FilterComponent />}
				onRowClicked={(e) => getPlayerName(e)}
				expandableRows
				expandableRowsComponent={<PlayerCard />}
			/>
			{name}
		</div>
	);
};

export default DataView;
