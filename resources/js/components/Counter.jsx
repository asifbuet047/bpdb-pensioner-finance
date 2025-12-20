import { useState } from "react";

export default function Counter() {
    const [count, setCount] = useState(0);

    return (
        <div className="d-flex justify-content-center mt-4">
            <div className="card shadow-sm" style={{ width: "18rem" }}>
                <div className="card-body text-center">
                    <h5 className="card-title mb-3">Counter</h5>

                    <p className="fs-4 fw-bold mb-4">{count}</p>

                    <div className="d-flex justify-content-center gap-2">
                        <button
                            className="btn btn-outline-danger"
                            onClick={() => setCount(count - 1)}
                        >
                            −
                        </button>

                        <button
                            className="btn btn-primary"
                            onClick={() => setCount(count + 1)}
                        >
                            +
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
