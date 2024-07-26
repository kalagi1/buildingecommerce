import React from "react";
import "./TopCreateProjectNavigator.css";

function TopCreateProjectNavigator({ step, setStep }) {
  return (
    <div id="navbarDefault">
      <div className="progress-area">
        <div className={"progress-line step" + step}>
          <ol>
            <li
              onClick={() => {
                if (step >= 1 && step < 4) setStep(1);
              }}
              className={step === 1 ? "current" : step > 1 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">1</span>
              </a>
              <span className="step-counter-title">Kategori Seçimi</span>
            </li>
            <li
              onClick={() => {
                if (step >= 2 && step < 4) setStep(2);
              }}
              className={step === 2 ? "current" : step > 2 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">2</span>
              </a>
              <span className="step-counter-title">İlan Detayları</span>
            </li>
            <li
              onClick={() => {
                if (step >= 3 && step < 4) setStep(3);
              }}
              className={step === 3 ? "current" : step > 3 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">3</span>
              </a>
              <span className="step-counter-title">Önizleme</span>
            </li>
            <li
              onClick={() => {
                if (step === 4) setStep(4);
              }}
              className={step === 4 ? "current" : step > 4 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">4</span>
              </a>
              <span className="step-counter-title">Tebrikler</span>
            </li>
          </ol>
        </div>
      </div>
    </div>
  );
}

export default TopCreateProjectNavigator;
