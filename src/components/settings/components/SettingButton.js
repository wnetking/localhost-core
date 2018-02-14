import { h } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import { toggleSettings } from "../actions";

function SettingButton({ type, toggleSettings, settings }) {
  return (
    <button className="btn" onClick={toggleSettings}>
      {`Settings`}
    </button>
  );
}

const mapDispatchToProps = dispatch => ({
  toggleSettings: bindActionCreators(toggleSettings, dispatch)
});

export default connect(state => state, mapDispatchToProps)(SettingButton);
