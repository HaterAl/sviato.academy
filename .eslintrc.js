module.exports = {
    "env": {
        "browser": true,
        "es2021": true,
        "node": true,
    },
    "extends": "eslint:recommended",
    "overrides": [
    ],
    "parserOptions": {
        "ecmaVersion": "latest",
        "sourceType": "module",
    },
    "rules": {
        "comma-dangle": ["error", "always-multiline"],
        "curly": [2, "multi-line"],
        "indent": ["error", 4, {
            "SwitchCase": 1,
        }],
        "no-plusplus": ["error", { "allowForLoopAfterthoughts": true }],
        "semi": ["error", "never"],
    },
}
