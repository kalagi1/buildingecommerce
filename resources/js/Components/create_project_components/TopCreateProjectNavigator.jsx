import React, { useEffect, useState } from "react";
import "./TopCreateProjectNavigator.css";

function TopCreateProjectNavigator({ step, setStep }) {
  const [showModal, setShowModal] = useState(false);

  useEffect(() => {
    const savedStep = localStorage.getItem("currentStep");
    if (savedStep) {
      setStep(Number(savedStep));
    } else {
      setShowModal(true);
    }
  }, [setStep]);

  const handleContinue = () => {
    setShowModal(false);
    localStorage.setItem("currentStep", step);
  };

  const handleStartNew = () => {
    setStep(1);
    setShowModal(false);
    localStorage.removeItem("currentStep");
  };

  return (
    <div id="navbarDefault">
      {showModal && (
        <div className="modal">
          <div className="modal-content">
            <h2>Devam Etmek İster misiniz?</h2>
            <button onClick={handleContinue}>Devam Et</button>
            <button onClick={handleStartNew}>Yeni İlan Oluştur</button>
          </div>
        </div>
      )}
      <div className="progress-area">
        <div className={"progress-line step" + step}>
          <ol>
            <li
              onClick={() => {
                setStep(1);
              }}
              className={step === 1 ? "current" : step > 1 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">1</span>
              </a>
              <a onClick={() => setStep(1)}>Kategori Seçimi</a>
            </li>
            <li
              onClick={() => {
                setStep(2);
              }}
              className={step === 2 ? "current" : step > 2 ? "done" : ""}
            >
              <a className="step-counter">
                <span className="step-counter-number">2</span>
              </a>
              <a onClick={() => setStep(2)}>İlan Detayları</a>
            </li>
            <li className={step === 3 ? "current" : step > 3 ? "done" : ""}>
              <a className="step-counter">
                <span className="step-counter-number">3</span>
              </a>
              <a onClick={() => setStep(3)}>Tebrikler</a>
            </li>
          </ol>
        </div>
      </div>
    </div>
  );
}

export default TopCreateProjectNavigator;
