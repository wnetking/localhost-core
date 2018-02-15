import { h, Component } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { changeSettings } from "../actions";
import SettingButton from "./SettingButton";
import t from "../../../translations";
import dumbData from "../dumbData";

class Settings extends Component {
  handleViewChange({ target }) {
    let { changeSettings } = this.props;
    changeSettings({
      [target.dataset.group]: target.value
    });
  }

  render() {
    let { settings } = this.props;
    return (
      <div
        className="setting-popup"
        style={{ display: settings.show ? "flex" : "none" }}
      >
        <div className="setting-inner">
          <h2>{t(`Settings`, settings.lang)}</h2>
          <div className="variants">
            {dumbData.map((item, index) => (
              <p key={index}>
                <span className="variant-title">
                  {t(item.title, settings.lang)}
                </span>
                <select
                  value={settings[item.group]}
                  onChange={this.handleViewChange.bind(this)}
                  data-group={item.group}
                >
                  {item.values.map((item, index) => (
                    <option key={index} value={item.value}>
                      {t(item.name, settings.lang)}
                    </option>
                  ))}
                </select>
              </p>
            ))}
          </div>
          <div className="popup-footer">
            <SettingButton title={"Close"} />
          </div>
        </div>
      </div>
    );
  }
}

const mapDispatchToProps = dispatch => ({
  changeSettings: bindActionCreators(changeSettings, dispatch)
});

export default connect(state => state, mapDispatchToProps)(Settings);
