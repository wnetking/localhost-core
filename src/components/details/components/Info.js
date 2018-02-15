import { h, Component } from "preact";
import { connect } from "preact-redux";
import { bindActionCreators } from "redux";
import BaseProjectInfo from "./BaseProjectInfo";
import ModuleList from "./ModuleList";
import Button from "./Button";
import CloseDetails from "./CloseDetails";
import t from "../../../translations";
import { clearDbRequest, removeProject } from "../actions";

class Info extends Component {
  render() {
    let { details, clearDbRequest, removeProject, settings } = this.props;
    return (
      <div
        className="setting-popup"
        style={{ display: details.show ? "flex" : "none" }}
      >
        {!details.fatching ? (
          <div className="setting-inner">
            <CloseDetails />
            <h2>{t(`Project Info`, settings.lang)}</h2>
            <BaseProjectInfo />
            <ModuleList data={details.data.modules} />
            <div>
              {details.type !== "other" && details.data ? (
                <span>
                  <Button
                    onClick={clearDbRequest.bind(
                      null,
                      details.projectName,
                      details.type
                    )}
                  >
                    {t(`Clear data base`, settings.lang)}
                  </Button>
                  <span className="btn">|</span>
                </span>

              ) : (
                ""
              )}
              <Button
                onClick={removeProject.bind(
                  null,
                  details.projectName,
                  details.type
                )}
              >
                {t(`Remove Project`, settings.lang)}
              </Button>
              <p>
                {details.message ? details.message : ""}
                {details.makeRequest ? "Loading ..." : ""}
              </p>
            </div>
          </div>
        ) : (
          "Loading.."
        )}
      </div>
    );
  }
}

const mapDispatchToProps = dispatch => ({
  clearDbRequest: bindActionCreators(clearDbRequest, dispatch),
  removeProject: bindActionCreators(removeProject, dispatch)
});

export default connect(state => state, mapDispatchToProps)(Info);
