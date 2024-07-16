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
                setStep(1);
              }}
              className={step === 1 ? "current" : step > 1 ? "done" : ""}
            >
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                  setStep(1);
                }}
                className="step-counter"
              >
                <span className="step-counter-number">1</span>
              </a>
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                  setStep(1);
                }}
              >
                Kategori Seçimi
              </a>
            </li>
            <li
              onClick={() => {
                setStep(2);
              }}
              className={step === 2 ? "current" : step > 2 ? "done" : ""}
            >
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                  setStep(2);
                }}
                className="step-counter"
              >
                <span className="step-counter-number">2</span>
              </a>
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                  setStep(2);
                }}
              >
                İlan Detayları
              </a>
            </li>
            <li className={step === 3 ? "current" : step > 3 ? "done" : ""}>
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                }}
                className="step-counter"
              >
                <span className="step-counter-number">3</span>
              </a>
              <a
                onClick={(e) => {
                  e.stopPropagation();
                  e.preventDefault();
                }}
              >
                Tebrikler
              </a>
            </li>
          </ol>
        </div>
      </div>
    </div>
  );
}

export default TopCreateProjectNavigator;
