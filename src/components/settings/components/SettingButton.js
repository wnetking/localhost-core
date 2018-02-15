import { h } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import t from "../../../translations";
import { toggleSettings } from "../actions";

function SettingButton({ type, toggleSettings, settings, children, title }) {
  return (
    <button className="btn toggle" onClick={toggleSettings}>
      {t(title, settings.lang)}
    </button>
  );
}

const mapDispatchToProps = dispatch => ({
  toggleSettings: bindActionCreators(toggleSettings, dispatch)
});

export default connect(state => state, mapDispatchToProps)(SettingButton);
