import { h, Component } from "preact";
import { connect } from "preact-redux";
import t from "../../../translations";

function ModuleList({ details, settings }) {
  return (
    <div className="module-list">
      {details.data ? (
        <div>
          <div class="title">{t(`Modules`, settings.lang)}</div>
          <table>
            <tr>
              <th>{t(`name`, settings.lang)}</th>
              <th>{t(`version`, settings.lang)}</th>
            </tr>
            {details.data.modules ? details.data.modules.map(item => (
              <tr>
                <td>{item.name}</td>
                <td>{item.version}</td>
              </tr>
            )): ''}
          </table>
        </div>
      ) : (
        ""
      )}
    </div>
  );
}

export default connect(state => state)(ModuleList);
