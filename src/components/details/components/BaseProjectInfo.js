import { h, Component } from "preact";

function BaseProjectInfo({ data }) {
  return (
    <ul>
      <li>Project Name : {data.project_name}</li>
      <li>Shop Name : {data.shop_name}</li>
      <li>PS version : {data.prestashop_vesion}</li>
      <li>Create : {new Date(data.shop_create).toLocaleDateString()}</li>
      <li>Data base name : {data.data_base}</li>
    </ul>
  );
}

export default BaseProjectInfo;
