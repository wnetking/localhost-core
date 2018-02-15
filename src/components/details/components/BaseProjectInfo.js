import { h, Component } from "preact";
import { connect } from "preact-redux";
import t from "../../../translations";

function BaseProjectInfo({ details, settings }) {
  let { data } = details;
  return (
    <div>
      {details.data ? (
        <ul className="base-project-info">
          <li>
            {t(`Project Name`, settings.lang)} : {data.project_name}
          </li>
          <li>
            {t(`Shop Name`, settings.lang)}
            : {data.shop_name}
          </li>
          <li>
            {t(`PS version`, settings.lang)} : {data.prestashop_vesion}
          </li>
          <li>
            {t(`Create`, settings.lang)}
            : {new Date(data.shop_create).toLocaleDateString()}
          </li>
          <li>
            {t(`Data base name`, settings.lang)}
            : {data.data_base}
          </li>
        </ul>
      ) : (
        ""
      )}
    </div>
  );
}

export default connect(state => state)(BaseProjectInfo);
