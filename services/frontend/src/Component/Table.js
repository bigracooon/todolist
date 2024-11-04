function Table()
{
	return (
		<div className="App">
			<table className="table">
				<thead>
				<tr>
					<th scope="col">Источник</th>
					<th scope="col">Ожидание</th>
					<th scope="col">Факт</th>
					<th scope="col">Разница</th>
					<th scope="col">Комментарий</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<th scope="row">Syrve</th>
					<td>1200000</td>
					<td>0</td>
					<td>-1200000</td>
					<td></td>
				</tr>
				<tr>
					<th scope="row">Саня должна</th>
					<td>50000</td>
					<td>0</td>
					<td>-50000</td>
					<td></td>
				</tr>
				</tbody>
			</table>
		</div>
	);
}

export default Table;