package main

// MCPConfig MCP 服务配置
type MCPConfig struct {
	// TokenServiceBaseURL token-sr 服务的基础 URL
	TokenServiceBaseURL string
}

// DefaultConfig 返回默认配置，指向本地 token-sr 服务
func DefaultConfig() *MCPConfig {
	return &MCPConfig{
		TokenServiceBaseURL: "http://localhost:8888",
	}
}
